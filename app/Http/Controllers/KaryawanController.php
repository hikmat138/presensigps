<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\LiburNasional;
use App\Models\Izin;
use App\Models\Admin;
use App\Models\Lokasi;
use App\Models\Pegawai;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = DB::table('pegawai')
            ->orderBy('nama_lengkap')
            ->paginate(2);

        $admin = Auth::guard('user')->user();
        
        return view('karyawan.index', compact('karyawan', 'admin'));
    }

    public function store(Request $request)
    {
        $nik          = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan      = $request->jabatan;
        $no_hp        = $request->no_hp;
        $password     = Hash::make('12345');

        try {
            $karyawan = DB::table('pegawai')->where('nik', $nik)->first();
            if ($karyawan) {
                return Redirect::back()->with(['error' => 'NIK sudah terdaftar']);
            }

            $data = [
                'nik'          => $nik,
                'nama_lengkap' => $nama_lengkap,
                'jabatan'      => $jabatan,
                'no_hp'        => $no_hp,
                'password'     => $password,
                'foto'         => null
            ];

            $simpan= DB::table('pegawai')->insert($data);
            if($simpan){
             return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
            } 
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Disimpan']);
        }
    }

    // 🔹 Ambil data untuk form edit (AJAX)
    public function edit(Request $request)
    {
        $nik = $request->nik;
        $karyawan = DB::table('pegawai')->where('nik', $nik)->first();
        return view('karyawan.edit', compact('karyawan'));
    }

    // 🔹 Update data
    public function update(Request $request, $nik)
{
    $nama_lengkap = $request->nama_lengkap;
    $jabatan      = $request->jabatan;
    $no_hp        = $request->no_hp;

    try {
        $data = [
            'nama_lengkap' => $nama_lengkap,
            'jabatan'      => $jabatan,
            'no_hp'        => $no_hp,
        ];

        $update= DB::table('pegawai')
            ->where('nik', $nik)
            ->update($data);
        if($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Diubah']);
        }
        
    } catch (\Exception $e) {
        return Redirect::back()->with(['error' => 'Data Gagal Diubah']);
    }
}


    // 🔹 Hapus data
    public function destroy($nik)
    {
        $delete = DB::table('pegawai')->where('nik', $nik)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect::back()->with(['error' => 'Data Gagal Dihapus']);
        }
    }

    public function profil()
    {
        $email = Auth::guard('user')->user()->email;
        $admin = Admin::where('email', $email)->first();

        return view('karyawan.profiladmin', compact('admin'));
    }

    public function editprofil()
    {
        $email = Auth::guard('user')->user()->email;
        $admin = Admin::where('email', $email)->first();

        return view('karyawan.editprofiladmin', compact('admin'));
    }

    public function updateprofil(Request $request)
    {
        $admin = Auth::guard('user')->user();

        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'nullable|string|max:100',
            'password' => 'nullable|string|max:20',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = $admin->id . "." . $foto->getClientOriginalExtension();
            $foto->move(public_path('uploads/pegawai/'), $filename);
            $data['foto'] = $filename;
        }

        Admin::where('id', $admin->id)->update($data);

        return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui');
    }

    public function jadwal()
{
    $jadwal = DB::table('jadwal')->get();
    $libur = LiburNasional::orderBy('tanggal','asc')->get();
    $admin = Auth::guard('user')->user();

    return view('karyawan.jadwal', compact('jadwal','libur','admin'));
}
    public function updateJam(Request $request, $id)
{
    $request->validate([
        'tipe' => 'required|in:masuk,pulang',
        'jam'  => 'required|date_format:H:i'
    ]);

    // Tentukan field
    $field = $request->tipe === 'masuk' ? 'jam_masuk' : 'jam_pulang';

    // Ubah format jadi H:i:s (sesuai tipe kolom TIME di MySQL)
    $jamFormatted = $request->jam . ':00';

    try {
        DB::table('jadwal')
            ->where('id', $id)
            ->update([
                $field => $jamFormatted
            ]);

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage() // biar tau error aslinya
        ], 500);
    }
}



    public function monitoring(){
        $admin = Auth::guard('user')->user();
        return view('karyawan.monitoring', compact('admin'));
    }

    public function getpresensi(Request $request){
    $tanggal = $request->tanggal;

    $presensi = DB::table('pegawai')
    ->leftJoin('presensi_pegawai', function($join) use ($tanggal) {
        $join->on('pegawai.nik', '=', 'presensi_pegawai.nik')
             ->whereDate('presensi_pegawai.tgl_presensi', $tanggal);
    })
    ->leftJoin('izin', function($join) use ($tanggal) {
        $join->on('pegawai.nik', '=', 'izin.nik')
             ->whereDate('izin.tgl_izin', $tanggal)
             ->where('izin.status_aproved', 1); // hanya izin disetujui
    })
    ->leftJoin('dinas', function($join) use ($tanggal) {
        $join->on('pegawai.nik', '=', 'dinas.nik')
             ->whereDate('dinas.tgl_awaldinas', '<=', $tanggal)
             ->whereDate('dinas.tgl_akhirdinas', '>=', $tanggal)
             ->where('dinas.status_aproved', 1); // hanya dinas disetujui
    })
    ->select(
        'pegawai.nik',
        'pegawai.nama_lengkap',
        'pegawai.jabatan',
        'presensi_pegawai.jam_in',
        'presensi_pegawai.jam_out',
        'izin.status as izin_status',
        'izin.keterangan as izin_ket',
        'dinas.keterangan as dinas_ket'
    )
    ->get()
    ->map(function($d) use ($tanggal) {
        // default value
        $d->jamIn = $d->jamOut = null;
        $d->ketMasuk = $d->ketPulang = "-";

        $hariIndo = [
            'Sunday' => 'Minggu','Monday' => 'Senin','Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu','Thursday' => 'Kamis','Friday' => "Jum'at",
            'Saturday' => 'Sabtu'
        ];
        $hari = $hariIndo[date('l', strtotime($tanggal))];

        if ($hari === 'Minggu') {
            $d->ketMasuk = $d->ketPulang = 'Libur';
            return $d;
        }

        // Kalau ada izin
        if ($d->izin_status) {
            $status = $d->izin_status == "S" ? "Sakit" : "Izin";
            $keterangan = $d->izin_ket ?? "-";

            $d->jamIn = $d->jamOut = $status;
            $d->ketMasuk = $d->ketPulang = $keterangan;
            return $d;
        }

        // Kalau ada dinas
        if ($d->dinas_ket) {
            $d->jamIn = $d->jamOut = "Dinas Luar";
            $d->ketMasuk = $d->ketPulang = $d->dinas_ket;
            return $d;
        }

        // Kalau absen normal
        $jadwal = DB::table('jadwal')->where('hari', $hari)->first();
        $jamMasuk = optional($jadwal)->jam_masuk ?? "07:00:00";
        $jamPulang = optional($jadwal)->jam_pulang ?? "14:00:00";

        if ($d->jam_in) {
            $d->jamIn = $d->jam_in;
            $d->ketMasuk = ($d->jam_in > $jamMasuk) ? 'Telat' : 'Tepat Waktu';
        } else {
            $d->ketMasuk = 'Tidak Absen Masuk';
        }

        if ($d->jam_out) {
            $d->jamOut = $d->jam_out;
            $d->ketPulang = ($d->jam_out < $jamPulang) ? 'Pulang Cepat' : 'Tepat Waktu';
        } else {
            $d->ketPulang = 'Tidak Absen Pulang';
        }

        return $d;
    });


    return view('karyawan.getpresensi', compact('presensi','tanggal'));
    }

    public function libur()
    {
        $libur = LiburNasional::orderBy('tanggal','asc')->get();
        return view('karyawan.jadwal', compact('libur'));
    }
    public function storelibur(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:100'
        ]);

        LiburNasional::create([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Libur berhasil ditambahkan.');
    }

    /**
     * Hapus data libur
     */
    public function destroylibur($id)
    {
        $libur = LiburNasional::findOrFail($id);
        $libur->delete();

        return back()->with('success', 'Libur berhasil dihapus.');
    }
     public function monitoringbulanan(){
        $admin = Auth::guard('user')->user();
        return view('karyawan.monitoringbulanan', compact('admin'));
    }
    public function getBulanan(Request $request)
{
    $bulan = $request->bulan; 
    $tahun = $request->tahun;

    $namaBulanSingkat = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar',
        4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
        7 => 'Jul', 8 => 'Agu', 9 => 'Sep',
        10 => 'Okt', 11 => 'Nov', 12 => 'Des'
    ];
    $namaBulanIndo = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
        4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
        10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    $namaBulan = $namaBulanIndo[intval($bulan)];

    $jmlHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

    $pegawai = DB::table('pegawai')->orderBy('nama_lengkap')->get();

    // ambil presensi
    $presensi = DB::table('presensi_pegawai')
        ->whereYear('tgl_presensi', $tahun)
        ->whereMonth('tgl_presensi', $bulan)
        ->get();

    $dataPresensi = [];
    foreach ($presensi as $p) {
        $dataPresensi[$p->nik][$p->tgl_presensi] = [
            'jam_masuk'  => $p->jam_in,
            'jam_pulang' => $p->jam_out,
        ];
    }

    // ambil izin approved
    $izin = DB::table('izin')
        ->whereYear('tgl_izin', $tahun)
        ->whereMonth('tgl_izin', $bulan)
        ->where('status_aproved', 1)
        ->get();

    $dataIzin = [];
    foreach ($izin as $iz) {
        $tgl = $iz->tgl_izin;
        $dataIzin[$iz->nik][$tgl] = $iz->status . " - " . $iz->keterangan;
    }

    // ambil dinas approved
    $dinas = DB::table('dinas')
        ->where('status_aproved', 1)
        ->get();

    $dataDinas = [];
    foreach ($dinas as $dn) {
        $mulai = strtotime($dn->tgl_awaldinas);
        $selesai = strtotime($dn->tgl_akhirdinas);
        for ($t = $mulai; $t <= $selesai; $t = strtotime("+1 day", $t)) {
            $tgl = date("Y-m-d", $t);
            if (date('Y', $t) == $tahun && date('n', $t) == $bulan) {
                $dataDinas[$dn->nik][$tgl] = $dn->keterangan;
            }
        }
    }

    $liburNasional = DB::table('libur_nasionals')
        ->whereYear('tanggal', $tahun)
        ->whereMonth('tanggal', $bulan)
        ->pluck('keterangan', 'tanggal')
        ->toArray();

    // buat thead
    $thead  = "<tr>";
    $thead .= "<th rowspan='2'>No</th>";
    $thead .= "<th rowspan='2'>Nama</th>";
    $thead .= "<th rowspan='2'>Jabatan</th>";
    for ($i=1; $i <= $jmlHari; $i++) {
        $tgl = $tahun."-".str_pad($bulan,2,'0',STR_PAD_LEFT)."-".str_pad($i,2,'0',STR_PAD_LEFT);
        $hari = date('w', strtotime($tgl));
        $isMinggu = ($hari==0);
        $isLiburNasional = array_key_exists($tgl, $liburNasional);

        $style = ($isMinggu || $isLiburNasional) 
            ? " class='bg-danger text-white text-center'" 
            : " class='text-center'";

        $thead .= "<th colspan='2' $style>".$i." ".$namaBulanSingkat[intval($bulan)]."</th>";
    }
    $thead .= "</tr><tr>";
    for ($i=1; $i <= $jmlHari; $i++) {
        $thead .= "<th class='text-center'>In</th><th class='text-center'>Out</th>";
    }
    $thead .= "</tr>";

    // buat tbody
    $tbody = "";
    $no = 1;
    foreach ($pegawai as $pg) {
        $tbody .= "<tr>";
        $tbody .= "<td>".$no++."</td>";
        $tbody .= "<td>".$pg->nama_lengkap."</td>";
        $tbody .= "<td>".$pg->jabatan."</td>";

        for ($i=1; $i <= $jmlHari; $i++) {
            $tgl = $tahun."-".str_pad($bulan,2,'0',STR_PAD_LEFT)."-".str_pad($i,2,'0',STR_PAD_LEFT);

            $hari = date('w', strtotime($tgl));
            $isMinggu = ($hari==0);
            $isLiburNasional = array_key_exists($tgl, $liburNasional);

            if ($isMinggu) {
                $tbody .= "<td colspan='2' class='text-center text-danger'>Libur Minggu</td>";
            } elseif ($isLiburNasional) {
                $tbody .= "<td colspan='2' class='text-center text-danger'>Libur Nasional - ".$liburNasional[$tgl]."</td>";
            } elseif (isset($dataIzin[$pg->nik][$tgl])) {
                $tbody .= "<td colspan='2' class='text-center text-primary'>".$dataIzin[$pg->nik][$tgl]."</td>";
            } elseif (isset($dataDinas[$pg->nik][$tgl])) {
                $tbody .= "<td colspan='2' class='text-center text-info'>Dinas Luar: ".$dataDinas[$pg->nik][$tgl]."</td>";
            } else {
                $jamMasuk  = $dataPresensi[$pg->nik][$tgl]['jam_masuk']  ?? '-';
                $jamPulang = $dataPresensi[$pg->nik][$tgl]['jam_pulang'] ?? '-';

                $ketMasuk = "";
                $ketPulang = "";

                if ($jamMasuk != '-' && $jamMasuk != null) {
                    $jamMasuk = date("H:i", strtotime($jamMasuk));
                    if (strtotime($jamMasuk) > strtotime("07:00")) {
                        $ketMasuk = "<div><span class='text-danger small'>Terlambat</span></div>";
                    }
                }

                if ($jamPulang != '-' && $jamPulang != null) {
                    $jamPulang = date("H:i", strtotime($jamPulang));
                    if (strtotime($jamPulang) < strtotime("16:00")) {
                        $ketPulang = "<div><span class='text-warning small'>Pulang Cepat</span></div>";
                    }
                }

                $tbody .= "<td class='text-center'>".$jamMasuk.$ketMasuk."</td>";
                $tbody .= "<td class='text-center'>".$jamPulang.$ketPulang."</td>";
            }
        }

        $tbody .= "</tr>";
    }

    return response()->json([
        'thead' => $thead,
        'tbody' => $tbody,
        'judul' => "Rekap Bulanan: $namaBulan $tahun",
    ]);
}


public function lokasi()
{
    $admin = Auth::guard('user')->user();
    $lokasi = Lokasi::first(); // ambil satu lokasi kantor utama

    return view('karyawan.lokasi', compact('lokasi','admin'));
}

public function updatelokasi(Request $request)
{
    $request->validate([
        'lokasi_kantor' => 'required|string|max:255',
        'latitude'      => 'required|numeric',
        'longitude'     => 'required|numeric',
        'radius'        => 'required|integer|min:50|max:1000'
    ]);

    $lokasi = Lokasi::first();
    if ($lokasi) {
        $lokasi->update($request->all());
    } else {
        Lokasi::create($request->all());
    }

    return back()->with('success', 'Lokasi kantor berhasil diperbarui');
}
public function konfirmasiizin(Request $request){
    $query = Izin :: query();
    $query->select('id','tgl_izin','pegawai.nama_lengkap','status','status_aproved');
    $query->join('pegawai','izin.nik','=','pegawai.nik');
    if(!empty($request->dari)&&!empty($request->sampai)){
        $query->whereBetween('tgl_izin',[$request->dari,$request->sampai]);
    }
    if(!empty($request->nama_pegawai)){
        $query->where('pegawai.nama_lengkap','like','%'.$request->nama_pegawai.'%');
    }
    if(!empty($request->status_filterizin)){
        $query->where('status',$request->status_filterizin);
    }
    if($request->status_filter !== ""){
        $query->where('status_aproved',$request->status_filter);
    }
    $query->orderby('tgl_izin','desc');
    $izinsakit = $query->get();
    $pegawai = Pegawai::orderBy('nama_lengkap')->get();
    $admin = Auth::guard('user')->user();
    return view('karyawan.konfirmasiizin',compact('admin','izinsakit','pegawai'));
}

public function aprovedizin(Request $request){
    $status_aproved=$request->status_aproved;
    $idizin=$request->idizin;
    $update=DB::table('izin')->where('id',$idizin)->update([
        'status_aproved' => $status_aproved
    ]);
    if($update){
        return redirect::back()->with(['success'=>'Data Berhasil Di Update']);
    } else {
        return redirect::back()->with(['error'=>'Data Gagal Di Update']);
    }
}
public function batalizin($id){
    $update=DB::table('izin')->where('id',$id)->update([
        'status_aproved' => 0
    ]);
    if($update){
        return redirect::back()->with(['success'=>'Data Berhasil Di Update']);
    } else {
        return redirect::back()->with(['error'=>'Data Gagal Di Update']);
    }
}
public function konfirmasidinas(){
    $admin = Auth::guard('user')->user();
    $dinasluar = DB::table('dinas')
        ->join('pegawai', 'dinas.nik', '=', 'pegawai.nik')
        ->select(
            'dinas.*',
            'pegawai.nama_lengkap'
        )
        ->orderBy('pegawai.nama_lengkap')
        ->get();
    return view('karyawan.konfirmasidinas',compact('admin','dinasluar'));
}

public function aproveddinas(Request $request){
    $status_aproved=$request->status_aproved;
    $iddinas=$request->iddinas;
    $update=DB::table('dinas')->where('id',$iddinas)->update([
        'status_aproved' => $status_aproved
    ]);
    if($update){
        return redirect::back()->with(['success'=>'Data Berhasil Di Update']);
    } else {
        return redirect::back()->with(['error'=>'Data Gagal Di Update']);
    }
}
public function bataldinas($id){
    $update=DB::table('dinas')->where('id',$id)->update([
        'status_aproved' => 0
    ]);
    if($update){
        return redirect::back()->with(['success'=>'Data Berhasil Di Update']);
    } else {
        return redirect::back()->with(['error'=>'Data Gagal Di Update']);
    }
}

public function konfirmasiubah (){
    $admin = Auth::guard('user')->user();
   $requests = Pegawai::where('reset_request', true)->get();
    return view ('karyawan.konfirmasiubah', compact('admin','requests'));
}

public function resetPassword($nik)
{
    $pegawai = Pegawai::where('nik', $nik)->first();

    if (!$pegawai) {
        return redirect()->back()->with('error', 'Pegawai tidak ditemukan.');
    }

    // Reset ke password default (misalnya "123456")
    $pegawai->password = Hash::make('1234');  
    $pegawai->reset_request = false; 
    $pegawai->save();

    return redirect()->back()->with('success', 'Password pegawai ' . $pegawai->nama_lengkap . ' berhasil direset ke default (123456).');
}


    }


