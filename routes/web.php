<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Exports\PresensiExport;
use Maatwebsite\Excel\Facades\Excel;


route ::middleware(['guest:pegawai'])->group(function () {
    route ::get('/', function () {
        return view('login');
    })->name('login');
    route::get('/lupapassword', [App\Http\Controllers\DashboardController::class, 'lupapassword']);
    route::post('/prosesreset', [App\Http\Controllers\DashboardController::class, 'prosesreset']);
});

    route ::POST('/proseslogin', [App\Http\Controllers\AuthController::class, 'proseslogin'])->name('proseslogin');

route ::middleware(['auth:pegawai'])->group(function () {
    route ::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');   
    route ::post('/proseslogout', [App\Http\Controllers\AuthController::class, 'logout'])->name('proseslogout');
    route ::get('/presensi/create', [App\Http\Controllers\DashboardController::class, 'create'])->name('presensi.create');
    route ::post('/dashboard/store', [App\Http\Controllers\DashboardController::class, 'store'])->name('presensi.store');
    route::get('/profil', [DashboardController::class, 'profil'])->name('profil');
    route::get('/editprofil', [DashboardController::class, 'editprofil'])->name('editprofil');
    route::POST('/updateprofil', [DashboardController::class, 'updateprofil'])->name('updateprofil');
    route::get('/dashboard/histori',[DashboardController::class, 'histori']);
    route::get('/jadwal', [App\Http\Controllers\DashboardController::class, 'jadwal'])->name('jadwal');
    route::post('/gethistori', [App\Http\Controllers\DashboardController::class, 'gethistori'])->name('gethistori');
    route::get('/izin', [App\Http\Controllers\DashboardController::class, 'izin'])->name('izin');
    route::get('/buatizin', [App\Http\Controllers\DashboardController::class, 'buatizin'])->name('buatizin');
    route::post('/storeizin', [App\Http\Controllers\DashboardController::class, 'storeizin'])->name('storeizin');
    route::get('/dinas', [App\Http\Controllers\DashboardController::class, 'dinas'])->name('dinas');
    route::get('/buatdinas', [App\Http\Controllers\DashboardController::class, 'buatdinas'])->name('buatdinas');
    route::post('/storedinas', [App\Http\Controllers\DashboardController::class, 'storedinas'])->name('storedinas'); 
    route::get('/pengaturanuser', [App\Http\Controllers\DashboardController::class, 'pengaturan'])->name('pengaturan');
    route::POST('/updatepassword', [App\Http\Controllers\DashboardController::class, 'updatepassword']);
    
});

route ::middleware(['guest:user'])->group(function () {
    route ::get('/panel', function () {
        return view('loginadmin');
    })->name('loginadmin');
});
    route ::POST('panel/prosesloginadmin', [App\Http\Controllers\AuthController::class, 'prosesloginadmin'])->name('prosesloginadmin');

route ::middleware(['auth:user'])->group(function () {
    route::get('/panel/dashboardadmin', [App\Http\Controllers\DashboardController::class, 'dashboardadmin'])->name('dashboardadmin');
    route ::get('/panel/proseslogoutadmin', [App\Http\Controllers\AuthController::class, 'logoutadmin'])->name('proseslogoutadmin');
    route :: get('/karyawan', [App\Http\Controllers\karyawanController::class, 'index']);
    route :: POST('/karyawan/store', [App\Http\Controllers\karyawanController::class,'store'])->name('store');
    route::get('/profiladmin', [App\Http\Controllers\KaryawanController::class, 'profil'])->name('profil');
    route::get('/editprofiladmin', [App\Http\Controllers\KaryawanController::class, 'editprofil'])->name('editprofil');
    route::POST('/updateprofiladmin', [App\Http\Controllers\KaryawanController::class, 'updateprofil'])->name('updateprofil');
    route::POST('/karyawan/edit', [App\Http\Controllers\KaryawanController::class, 'edit'])->name('karyawan.edit');
    route::POST('/karyawan/{nik}/update', [App\Http\Controllers\KaryawanController::class, 'update'])->name('karyawan.update');
    route::POST('/karyawan/{nik}/delete', [App\Http\Controllers\KaryawanController::class, 'destroy'])->name('karyawan.destroy');
    route :: get('/jadwalkaryawan', [App\Http\Controllers\karyawanController::class, 'jadwal']);
    route::POST('/jadwal/update/{id}', [App\Http\Controllers\karyawanController::class, 'updateJam']);
    route::get('/monitoring', [App\Http\Controllers\karyawanController::class, 'monitoring']);
    route::get('/monitoringbulanan', [App\Http\Controllers\karyawanController::class, 'monitoringbulanan']);
    route::POST('/getpresensi', [App\Http\Controllers\karyawanController::class, 'getpresensi']);
    route::POST('/getbulanan', [App\Http\Controllers\karyawanController::class, 'getbulanan']);
    route::POST('/libur/store', [App\Http\Controllers\KaryawanController::class, 'storelibur'])->name('libur.store');
    route::DELETE('/libur/{id}', [App\Http\Controllers\KaryawanController::class, 'destroylibur'])->name('libur.destroy');
    route::POST('/updatelokasi', [App\Http\Controllers\karyawanController::class, 'updatelokasi']);
    route::get('/aturlokasi', [App\Http\Controllers\karyawanController::class, 'lokasi']);
    route::get('/konfirmasiizin', [App\Http\Controllers\karyawanController::class, 'konfirmasiizin']);
    route::POST('/aprovedizin', [App\Http\Controllers\karyawanController::class, 'aprovedizin']);
    route::get('{id}/batal', [App\Http\Controllers\karyawanController::class, 'batalizin']);
    route::get('/konfirmasidinas', [App\Http\Controllers\karyawanController::class, 'konfirmasidinas']);
    route::POST('/aproveddinas', [App\Http\Controllers\karyawanController::class, 'aproveddinas']);
    route::get('{id}/bataldinas', [App\Http\Controllers\karyawanController::class, 'bataldinas']);
    route::get('/konfirmasiubah', [App\Http\Controllers\karyawanController::class, 'konfirmasiubah']);
    route::post('/resetpassword{nik}', [App\Http\Controllers\karyawanController::class, 'resetPassword']);
    
});

