<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\storage;
use Carbon\Carbon;

class PresensiController extends Controller
{
    public function create()
    {
        $hariinii = date ('Y-m-d');
        $nik = Auth::guard('pegawai')->user()->nik;
        $cek = DB::table('presensi_pegawai')-> where('tgl_presensi', $hariinii )
            ->where('nik', $nik) ->count();
        return view('presensi.create', compact('cek'));
    }

    public function store(Request $request)
{
    $nik          = Auth::guard('pegawai')->user()->nik;
    $tgl_presensi = date('Y-m-d');
    $jam          = date('H:i:s');

    $latkantor    = -6.1019821; //ganti dengan latitude kantor
    $longkantor   = 106.1313513; //ganti dengan longitude kantor

    $lokasi      = $request->lokasi;
    $lokasiuser   = explode(",", $lokasi);
    $latuser      = $lokasiuser[0];
    $longuser     = $lokasiuser[1];
    
    $jarak        = $this->distance($latkantor, $longkantor, $latuser, $longuser);
    $radius        = $jarak['meters'];

    $cek = DB::table('presensi_pegawai')-> where('tgl_presensi', $tgl_presensi )
            ->where('nik', $nik) ->count();
    if ($cek >0){
        $Ket = "out";
    }else {
        $et = "in";
    }

    $image        = $request->image; // harus sama dengan name di form/JS
    $folderPath   = 'app/public/uploads/absensi/';
    $formname     = $nik . '-' . $tgl_presensi . '-'. $ket;
    $image_parts  = explode(";base64,", $image);
    $image_base64 = base64_decode($image_parts[1]);
    $filename     = $formname . '.png';
    $file         = $folderPath . $filename;
    $data         = [
        
    ];

    if ($radius > 100) {
        echo "error| Maaf, anda berada diluar jangkauan absen ";
    }
    else {
    if($cek > 0)
        {
    $data_pulang = [ 
        'jam_out'          => $jam,
        'location_out'       => $lokasi,
        'foto_out'         => $filename
        ];
    $update = DB::table ('presensi_pegawai') -> where('tgl_presensi', $tgl_presensi )
        ->where('nik', $nik) ->update($data_pulang);
        if ($update) {
            echo "success| Terima Kasih, Hati-hati di jalan| out";
            storage ::put($file, $image_base64);
            }
        else {
            echo "error| maaf, absen gagal, silahkan ulangi lagi | out";
            } 
        }
    else {
    $data = [
        'nik'          => $nik,
        'tgl_presensi' => $tgl_presensi,
        'jam_in'          => $jam,
        'location_in'       => $lokasi,
        'foto_in'         => $filename ];

    $simpan = DB::table('presensi_pegawai')->insert($data);
        if ($simpan) {
            echo "success| Terima Kasih, selamat bekerja| in";
            storage ::put($file, $image_base64);
            }
        else {
            echo "error | maaf, absen gagal, silahkan ulangi lagi | in";
            }
        }
    }
}
    //Menghitung Jarak
     function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }
}