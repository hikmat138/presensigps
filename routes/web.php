<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Exports\PresensiExport;
use Maatwebsite\Excel\Facades\Excel;


Route ::middleware(['guest:pegawai'])->group(function () {
    Route ::get('/', function () {
        return view('login');
    })->name('login');
    Route::get('/lupapassword', [App\Http\Controllers\DashboardController::class, 'lupapassword']);
    Route::post('/prosesreset', [App\Http\Controllers\DashboardController::class, 'prosesreset']);
});

    Route ::POST('/proseslogin', [App\Http\Controllers\AuthController::class, 'proseslogin'])->name('proseslogin');

Route ::middleware(['auth:pegawai'])->group(function () {
    Route ::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');   
    Route ::post('/proseslogout', [App\Http\Controllers\AuthController::class, 'logout'])->name('proseslogout');
    Route ::get('/presensi/create', [App\Http\Controllers\DashboardController::class, 'create'])->name('presensi.create');
    Route ::post('/dashboard/store', [App\Http\Controllers\DashboardController::class, 'store'])->name('presensi.store');
    Route::get('/profil', [DashboardController::class, 'profil'])->name('profil');
    Route::get('/editprofil', [DashboardController::class, 'editprofil'])->name('editprofil');
    Route::POST('/updateprofil', [DashboardController::class, 'updateprofil'])->name('updateprofil');
    Route::get('/dashboard/histori',[DashboardController::class, 'histori']);
    Route::get('/jadwal', [App\Http\Controllers\DashboardController::class, 'jadwal'])->name('jadwal');
    Route::post('/gethistori', [App\Http\Controllers\DashboardController::class, 'gethistori'])->name('gethistori');
    Route::get('/izin', [App\Http\Controllers\DashboardController::class, 'izin'])->name('izin');
    Route::get('/buatizin', [App\Http\Controllers\DashboardController::class, 'buatizin'])->name('buatizin');
    Route::post('/storeizin', [App\Http\Controllers\DashboardController::class, 'storeizin'])->name('storeizin');
    Route::get('/dinas', [App\Http\Controllers\DashboardController::class, 'dinas'])->name('dinas');
    Route::get('/buatdinas', [App\Http\Controllers\DashboardController::class, 'buatdinas'])->name('buatdinas');
    Route::post('/storedinas', [App\Http\Controllers\DashboardController::class, 'storedinas'])->name('storedinas'); 
    Route::get('/pengaturanuser', [App\Http\Controllers\DashboardController::class, 'pengaturan'])->name('pengaturan');
    Route::POST('/updatepassword', [App\Http\Controllers\DashboardController::class, 'updatepassword']);
    
});

Route ::middleware(['guest:user'])->group(function () {
    Route ::get('/panel', function () {
        return view('loginadmin');
    })->name('loginadmin');
});
    Route ::POST('panel/prosesloginadmin', [App\Http\Controllers\AuthController::class, 'prosesloginadmin'])->name('prosesloginadmin');

Route ::middleware(['auth:user'])->group(function () {
    Route::get('/panel/dashboardadmin', [App\Http\Controllers\DashboardController::class, 'dashboardadmin'])->name('dashboardadmin');
    Route ::get('/panel/proseslogoutadmin', [App\Http\Controllers\AuthController::class, 'logoutadmin'])->name('proseslogoutadmin');
    Route :: get('/karyawan', [App\Http\Controllers\karyawanController::class, 'index']);
    Route :: POST('/karyawan/store', [App\Http\Controllers\karyawanController::class,'store'])->name('store');
    Route::get('/profiladmin', [App\Http\Controllers\KaryawanController::class, 'profil'])->name('profil');
    Route::get('/editprofiladmin', [App\Http\Controllers\KaryawanController::class, 'editprofil'])->name('editprofil');
    Route::POST('/updateprofiladmin', [App\Http\Controllers\KaryawanController::class, 'updateprofil'])->name('updateprofil');
    Route::POST('/karyawan/edit', [App\Http\Controllers\KaryawanController::class, 'edit'])->name('karyawan.edit');
    Route::POST('/karyawan/{nik}/update', [App\Http\Controllers\KaryawanController::class, 'update'])->name('karyawan.update');
    Route::POST('/karyawan/{nik}/delete', [App\Http\Controllers\KaryawanController::class, 'destroy'])->name('karyawan.destroy');
    Route :: get('/jadwalkaryawan', [App\Http\Controllers\karyawanController::class, 'jadwal']);
    Route::POST('/jadwal/update/{id}', [App\Http\Controllers\karyawanController::class, 'updateJam']);
    Route::get('/monitoring', [App\Http\Controllers\karyawanController::class, 'monitoring']);
    Route::get('/monitoringbulanan', [App\Http\Controllers\karyawanController::class, 'monitoringbulanan']);
    Route::POST('/getpresensi', [App\Http\Controllers\karyawanController::class, 'getpresensi']);
    Route::POST('/getbulanan', [App\Http\Controllers\karyawanController::class, 'getbulanan']);
    Route::POST('/libur/store', [App\Http\Controllers\KaryawanController::class, 'storelibur'])->name('libur.store');
    Route::DELETE('/libur/{id}', [App\Http\Controllers\KaryawanController::class, 'destroylibur'])->name('libur.destroy');
    Route::POST('/updatelokasi', [App\Http\Controllers\karyawanController::class, 'updatelokasi']);
    Route::get('/aturlokasi', [App\Http\Controllers\karyawanController::class, 'lokasi']);
    Route::get('/konfirmasiizin', [App\Http\Controllers\karyawanController::class, 'konfirmasiizin']);
    Route::POST('/aprovedizin', [App\Http\Controllers\karyawanController::class, 'aprovedizin']);
    Route::get('{id}/batal', [App\Http\Controllers\karyawanController::class, 'batalizin']);
    Route::get('/konfirmasidinas', [App\Http\Controllers\karyawanController::class, 'konfirmasidinas']);
    Route::POST('/aproveddinas', [App\Http\Controllers\karyawanController::class, 'aproveddinas']);
    Route::get('{id}/bataldinas', [App\Http\Controllers\karyawanController::class, 'bataldinas']);
    Route::get('/konfirmasiubah', [App\Http\Controllers\karyawanController::class, 'konfirmasiubah']);
    Route::post('/resetpassword/{nik}', [App\Http\Controllers\karyawanController::class, 'resetPassword']);
    
});

