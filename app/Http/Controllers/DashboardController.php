<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Models\Pegawai;
use App\Models\LiburNasional;
use App\Models\Lokasi;
use App\Models\Absen;
use Carbon\Carbon;


\Carbon\Carbon::setLocale('id');

class DashboardController extends Controller
{
    // Dashboard utama
    public function index()
{
    $jam_sekarang = Carbon::now()->format('H:i:s');
    $hariini = date("Y-m-d");
    $bulanini = date("m") * 1;
    $tahunini = date("Y");
    $nik = Auth::guard('pegawai')->user()->nik;

    $pegawai = Pegawai::where('nik', $nik)->first();

    $presensihariini = DB::table('presensi_pegawai')
        ->where('nik', $nik)
        ->where('tgl_presensi', $hariini)
        ->first();

    // Mapping hari ke bahasa Indonesia
    $hariIndo = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => "Jum'at",
        'Saturday' => 'Sabtu'
    ];
    $hariSekarang = $hariIndo[date('l')];

    // Ambil jadwal sesuai hari
    $jadwal = DB::table('jadwal')->where('hari', $hariSekarang)->first();
    $jamMasuk = optional($jadwal)->jam_masuk ?? "07:00:00";
    $jamPulang = optional($jadwal)->jam_pulang ?? "14:00:00";


    // History bulan ini
    $historibulanini = DB::table('presensi_pegawai')
        ->where('nik', $nik)
        ->whereRaw('MONTH(tgl_presensi)= ?', [$bulanini])
        ->whereRaw('YEAR(tgl_presensi) = ?', [$tahunini])
        ->orderBy('tgl_presensi')
        ->get();

    // Rekap absen sesuai jadwal dinamis
    $rekap = DB::table('presensi_pegawai')
        ->selectRaw('
            COUNT(nik) as jmlhadir,
            SUM(CASE WHEN jam_in IS NOT NULL THEN 1 ELSE 0 END) as jmlhadirmasuk,
            SUM(CASE WHEN jam_out IS NOT NULL THEN 1 ELSE 0 END) as jmlpulang,
            SUM(CASE WHEN jam_in > ? THEN 1 ELSE 0 END) as jmltelat,
            SUM(CASE WHEN jam_out < ? THEN 1 ELSE 0 END) as jmlcepat,
            SUM(CASE WHEN jam_in IS NOT NULL AND jam_out IS NULL THEN 1 ELSE 0 END) as tidakabsenpulang,
            SUM(CASE WHEN jam_in IS NULL THEN 1 ELSE 0 END) as tidakabsenmasuk
        ', [$jamMasuk, $jamPulang])
        ->where('nik', $nik)
        ->first();

    // Rekap izin (sakit & izin) per tahun berjalan
    $rekapizin = DB::table('izin')
        ->selectRaw('
            SUM(IF(status="s",1,0)) as jml_sakit,
            SUM(IF(status="i",1,0)) as jml_izin
        ')
        ->where('nik', $nik)
        ->where('status_aproved', 1) // hanya yang disetujui
        ->first();

        // Rekap dinas (sakit & izin) per tahun berjalan
    $rekapdinas = DB::table('dinas')
        ->selectRaw('
            COUNT(nik) as jml_dinas
        ')
        ->where('nik', $nik)
        ->where('status_aproved', 1) // hanya yang disetujui
        ->first();

    // Leaderboard harian
    $leaderboard = DB::table('presensi_pegawai')
        ->join('pegawai', 'presensi_pegawai.nik', '=', 'pegawai.nik')
        ->where('tgl_presensi', $hariini)
        ->orderBy('jam_in')
        ->get();

    // Cek sudah absen hari ini atau belum
    $cek = DB::table('presensi_pegawai')
        ->where('nik', $nik)
        ->where('tgl_presensi', $hariini)
        ->count();

    // Nama bulan
    $namabulan = [
        "", "JANUARI", "FEBRUARI", "MARET", "APRIL", "MEI", "JUNI",
        "JULI", "AGUSTUS", "SEPTEMBER", "OKTOBER", "NOVEMBER", "DESEMBER"
    ];

    $kantor = DB::table('lokasi_kantor')->first();
    // Cek libur nasional
    $isMinggu = $hariSekarang === 'Minggu';
    $liburHariIni = LiburNasional::whereDate('tanggal', $hariini)->first();
    $isLiburNasional = $liburHariIni ? true : false;
    $keteranganLibur = $liburHariIni ? $liburHariIni->keterangan : null;

// Flag gabungan
    $isLibur = $isMinggu || $isLiburNasional;

    return view('dashboard.dashboard', compact(
        'cek','presensihariini','historibulanini','namabulan','bulanini','tahunini',
        'rekap','rekapizin','leaderboard','pegawai','jadwal','jamMasuk','jamPulang','jam_sekarang','rekapdinas','kantor'
        ,'isLibur','keteranganLibur'
    ));
}


    public function profil()
    {
        $nik = Auth::guard('pegawai')->user()->nik;
        $pegawai = Pegawai::where('nik', $nik)->first();
        return view('dashboard.profil', compact('pegawai'));
    }

    public function editprofil()
    {
        $nik = Auth::guard('pegawai')->user()->nik;
        $pegawai = Pegawai::where('nik', $nik)->first();
        return view('dashboard.editprofil', compact('pegawai'));
    }

    public function updateprofil(Request $request)
    {
        $pegawai = Auth::guard('pegawai')->user();

        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'jabatan'      => 'nullable|string|max:100',
            'no_hp'        => 'nullable|string|max:20',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan'      => $request->jabatan,
            'no_hp'        => $request->no_hp,
        ];

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = $pegawai->nik . "." . $foto->getClientOriginalExtension();
            $foto->move(public_path('uploads/pegawai/'), $filename);
            $data['foto'] = $filename;
        }

        DB::table('pegawai')->where('nik', $pegawai->nik)->update($data);

        return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui');
    }

    // Rumus haversine
    private function distance($lat1, $lon1, $lat2, $lon2) {
    $earthRadius = 6371000; // meter
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat/2) * sin($dLat/2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon/2) * sin($dLon/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));

    return ['meters' => $earthRadius * $c];
}


    // Proses Absen (masuk / pulang)
    

public function store(Request $request)
{
    $kantor = Lokasi::first(); // ambil lokasi kantor
    if (!$kantor) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Lokasi kantor belum diatur'
        ]);
    }

    // Ambil koordinat kantor dan radius
    $lat_kantor  = (float) $kantor->latitude;
    $lng_kantor  = (float) $kantor->longitude;
    $batasRadius = (float) ($kantor->radius ?? 100); // default 100 meter

    // Ambil koordinat user
    $lat_user = (float) $request->latitude;
    $lng_user = (float) $request->longitude;

    if (!$lat_user || !$lng_user) {
        return response()->json([
            'status' => 'error',
            'message' => 'Koordinat GPS tidak valid'
        ]);
    }

    // Hitung jarak user ke kantor
    $jarak = $this->distance($lat_kantor, $lng_kantor, $lat_user, $lng_user);
    $jarakUser = round($jarak['meters'], 0);

    if ($jarakUser > $batasRadius) {
        return response()->json([
            'status' => 'error',
            'message' => "Anda berada di luar jangkauan absen ($jarakUser m)"
        ]);
    }

    // Cek absen hari ini
    $today = date("Y-m-d");
    $nik   = Auth::guard('pegawai')->user()->nik;

    $cek = Absen::whereDate('tgl_absen', $today)
                ->where('nik', $nik)
                ->first();

    if ($cek) {
        // Absen pulang
        if ($cek->jam_out == null) {
            $cek->update([
                'jam_out'    => date("H:i:s"),
                'foto_out'   => $request->foto_out,
                'lokasi_out' => $request->lokasi
            ]);
            return response()->json([
                'status'  => 'success',
                'message' => 'Absen pulang berhasil'
            ]);
        } else {
            return response()->json([
                'status'  => 'warning',
                'message' => 'Anda sudah absen pulang hari ini'
            ]);
        }
    } else {
        // Absen masuk
        Absen::create([
            'nik'        => $nik,
            'tgl_absen'  => $today,
            'jam_in'     => date("H:i:s"),
            'foto_in'    => $request->foto_in,
            'lokasi_in'  => $request->lokasi
        ]);
        return response()->json([
            'status'  => 'success',
            'message' => 'Absen masuk berhasil'
        ]);
    }
}



    public function histori()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('dashboard.histori', compact('namabulan'));
    }

    public function jadwal()
    {
        $libur = LiburNasional::orderBy('tanggal','asc')->get();
        $jadwal = DB::table('jadwal')->get();
        return view('dashboard.jadwal', compact('jadwal','libur'));
    }

    public function gethistori (Request $request) {
        $nik = Auth::guard('pegawai')->user()->nik;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $histori = DB::table('presensi_pegawai')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi)= ?', [$bulan])
            ->whereRaw('YEAR(tgl_presensi) = ?', [$tahun])
            ->orderBy('tgl_presensi')
            ->get();

        return view('dashboard.gethistori', compact('histori'));
    }

    public function izin()
    {
        $nik = Auth::guard('pegawai')->user()->nik;
        $dataizin = DB::table('izin')->where('nik', $nik)->get();
        return view('dashboard.izin', compact('dataizin'));
    }

    public function buatizin()
    {
        return view('dashboard.buatizin');
    }

    public function storeizin(Request $request)
    {
        $nik = Auth::guard('pegawai')->user()->nik;

        $tgl_izin = $request->tgl_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $data = [
            'nik' => $nik,
            'tgl_izin' => $tgl_izin,
            'status' => $status,
            'keterangan' => $keterangan,
            'status_aproved' => 0, // default pending
        ];

        $simpan = DB::table('izin')->insert($data);

        if ($simpan) {
            return redirect('/Izin')->with('success', 'Izin berhasil diajukan');
        } else {
            return redirect('/buatizin')->with('error', 'Pengajuan izin gagal dikirim.');
        }
    }
    public function dinas()
    {
        $nik = Auth::guard('pegawai')->user()->nik;
        $datadinas = DB::table('dinas')->where('nik', $nik)->get();
        return view('dashboard.dinas', compact('datadinas'));
    }
    public function buatdinas()
    {
        return view('dashboard.buatdinas');
    }

    public function storedinas(Request $request)
{
    $nik = Auth::guard('pegawai')->user()->nik;

    $request->validate([
        'tgl_awaldinas'   => 'required|date',
        'tgl_akhirdinas'  => 'required|date|after_or_equal:tgl_awaldinas',
        'keterangan'      => 'required|string',
        'file_surat'      => 'nullable|mimes:pdf|max:2048',
    ]);

    $tgl_awaldinas   = $request->input('tgl_awaldinas');
    $tgl_akhirdinas  = $request->input('tgl_akhirdinas');
    $keterangan      = $request->input('keterangan');

    $file_surat = null;
    if ($request->hasFile('file_surat')) {
        $file = $request->file('file_surat');
        $filename = 'suratdinas_'. $nik . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/surat_dinas'), $filename);
        $file_surat = $filename;
    }

    $simpan = DB::table('dinas')->insert([
        'nik'            => $nik,
        'tgl_awaldinas'  => $tgl_awaldinas,
        'tgl_akhirdinas' => $tgl_akhirdinas,
        'keterangan'     => $keterangan,
        'file_surat'     => $file_surat,
        'status_aproved' => 0,
        'created_at'     => now(),
    ]);

    if ($simpan) {
        return redirect('/dinas')->with('success', 'Dinas luar berhasil diajukan');
    } else {
        return redirect('/buatdinas')->with('error', 'Pengajuan dinas luar gagal dikirim.');
    }
}

public function dashboardadmin()
{
    $jadwal = DB::table('jadwal')->where('hari', date('l'))->first();
    $jamMasuk = optional($jadwal)->jam_masuk ?? "07:00:00";
    $jamPulang = optional($jadwal)->jam_pulang ?? "14:00:00";
    $rekap = DB::table('presensi_pegawai')
        ->selectRaw('
            COUNT(nik) as jmlhadir,
            SUM(CASE WHEN jam_in IS NOT NULL THEN 1 ELSE 0 END) as jmlhadirmasuk,
            SUM(CASE WHEN jam_out IS NOT NULL THEN 1 ELSE 0 END) as jmlpulang,
            SUM(CASE WHEN jam_in > ? THEN 1 ELSE 0 END) as jmltelat,
            SUM(CASE WHEN jam_out < ? THEN 1 ELSE 0 END) as jmlcepat,
            SUM(CASE WHEN jam_in IS NOT NULL AND jam_out IS NULL THEN 1 ELSE 0 END) as tidakabsenpulang,
            SUM(CASE WHEN jam_in IS NULL THEN 1 ELSE 0 END) as tidakabsenmasuk',
            [$jamMasuk, $jamPulang])
        ->first();

        $rekapizin = DB::table('izin')
        ->selectRaw('
            SUM(IF(status="s",1,0)) as jml_sakit,
            SUM(IF(status="i",1,0)) as jml_izin
        ')
        ->where('status_aproved', 1)
        ->first();

        // Rekap dinas (sakit & izin) per tahun berjalan
    $rekapdinas = DB::table('dinas')
        ->selectRaw('
            COUNT(nik) as jml_dinas
        ')
        ->where('status_aproved', 1) 
        ->first();

    $jumlahPegawai = DB::table('pegawai')->count('nik');
    $admin = Auth::guard('user')->user();
    $lokasi = DB::table('lokasi_kantor')->first();
    return view('dashboard.dashboardadmin', compact('rekap','rekapizin','rekapdinas','jumlahPegawai','admin','lokasi'));
}
public function libur()
    {
        $libur = LiburNasional::orderBy('tanggal','asc')->get();
        return view('dashboard.jadwal', compact('libur'));
}
public function showMap()
{
    $lokasi = Lokasi::first();
    return view('dashboard.dashboardadmin', compact('lokasi'));
}
public function pengaturan(){
    return view('dashboard.pengaturan');
}
public function updatepassword (Request $request)
    {
        $request->validate([
            'password_baru' => 'required|string|min:6|confirmed', 
        ], [
            'password_baru.confirmed' => 'Konfirmasi password tidak sesuai.'
        ]);

        // Ambil user yang sedang login
        $user = Auth::guard('pegawai')->user();

        // Update password
        $user->password = Hash::make($request->password_baru);
        $user->save();

        return redirect('/pengaturanuser')->with('success', 'Password berhasil diubah!');
    }

    public function lupapassword(){
        return view('dashboard.lupapassword');
    }

    public function prosesReset(Request $request)
{
    $request->validate([
        'nik' => 'required|exists:pegawai,nik', // langsung validasi apakah nik ada di DB
    ], [
        'nik.required' => 'NIK wajib diisi.',
        'nik.exists'   => 'NIK tidak ditemukan dalam data pegawai.',
    ]);

    $pegawai = Pegawai::where('nik', $request->nik)->first();

    // Update flag reset_request jadi true
    $pegawai->reset_request = true;
    $pegawai->save();

    // redirect ke login dengan pesan sukses
    return redirect('/lupapassword')->with('success', 'Permintaan reset password sudah dikirim ke admin.');
}




}