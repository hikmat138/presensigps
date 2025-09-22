<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaryawanController;
use Maatwebsite\Excel\Facades\Excel;


Route::middleware(['guest:pegawai'])->group(function () {
    Route::get('/', function () {
        return view('login');
    })->name('login');

    Route::get('/lupapassword', [DashboardController::class, 'lupapassword']);
    Route::post('/prosesreset', [DashboardController::class, 'prosesreset']);
});


Route::post('/proseslogin', [AuthController::class, 'proseslogin'])->name('proseslogin');


Route::middleware(['auth:pegawai'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');   
    Route::post('/proseslogout', [AuthController::class, 'logout'])->name('proseslogout');
    
    Route::get('/presensi/create', [DashboardController::class, 'create'])->name('presensi.create');
    Route::post('/dashboard/store', [DashboardController::class, 'store'])->name('presensi.store');
    
    Route::get('/profil', [DashboardController::class, 'profil'])->name('profil');
    Route::get('/editprofil', [DashboardController::class, 'editprofil'])->name('editprofil');
    Route::post('/updateprofil', [DashboardController::class, 'updateprofil'])->name('updateprofil');
    Route::post('/updatepassword', [DashboardController::class, 'updatepassword'])->name('updatepassword');
    
    Route::get('/dashboard/histori', [DashboardController::class, 'histori']);
    Route::get('/jadwal', [DashboardController::class, 'jadwal'])->name('jadwal');
    Route::post('/gethistori', [DashboardController::class, 'gethistori'])->name('gethistori');
    
    Route::get('/izin', [DashboardController::class, 'izin'])->name('izin');
    Route::get('/buatizin', [DashboardController::class, 'buatizin'])->name('buatizin');
    Route::post('/storeizin', [DashboardController::class, 'storeizin'])->name('storeizin');
    
    Route::get('/dinas', [DashboardController::class, 'dinas'])->name('dinas');
    Route::get('/buatdinas', [DashboardController::class, 'buatdinas'])->name('buatdinas');
    Route::post('/storedinas', [DashboardController::class, 'storedinas'])->name('storedinas'); 
    
    Route::get('/pengaturanuser', [DashboardController::class, 'pengaturan'])->name('pengaturan');
});


Route::middleware(['guest:user'])->group(function () {
    Route::get('/panel', function () {
        return view('loginadmin');
    })->name('loginadmin');
});


Route::post('panel/prosesloginadmin', [AuthController::class, 'prosesloginadmin'])->name('prosesloginadmin');


Route::middleware(['auth:user'])->group(function () {
    Route::get('/panel/dashboardadmin', [DashboardController::class, 'dashboardadmin'])->name('dashboardadmin');
    Route::get('/panel/proseslogoutadmin', [AuthController::class, 'logoutadmin'])->name('proseslogoutadmin');

    Route::get('/karyawan', [KaryawanController::class, 'index']);
    Route::post('/karyawan/store', [KaryawanController::class, 'store'])->name('store');
    Route::get('/profiladmin', [KaryawanController::class, 'profil'])->name('profiladmin');
    Route::get('/editprofiladmin', [KaryawanController::class, 'editprofil'])->name('editprofiladmin');
    Route::post('/updateprofiladmin', [KaryawanController::class, 'updateprofil'])->name('updateprofiladmin');

    Route::post('/karyawan/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
    Route::post('/karyawan/{nik}/update', [KaryawanController::class, 'update'])->name('karyawan.update');
    Route::post('/karyawan/{nik}/delete', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');

    Route::get('/jadwalkaryawan', [KaryawanController::class, 'jadwal']);
    Route::post('/jadwal/update/{id}', [KaryawanController::class, 'updateJam']);

    Route::get('/monitoring', [KaryawanController::class, 'monitoring']);
    Route::get('/monitoringbulanan', [KaryawanController::class, 'monitoringbulanan']);
    Route::post('/getpresensi', [KaryawanController::class, 'getpresensi']);
    Route::post('/getbulanan', [KaryawanController::class, 'getbulanan']);

    Route::post('/libur/store', [KaryawanController::class, 'storelibur'])->name('libur.store');
    Route::delete('/libur/{id}', [KaryawanController::class, 'destroylibur'])->name('libur.destroy');

    Route::post('/updatelokasi', [KaryawanController::class, 'updatelokasi']);
    Route::get('/aturlokasi', [KaryawanController::class, 'lokasi']);

    Route::get('/konfirmasiizin', [KaryawanController::class, 'konfirmasiizin']);
    Route::post('/aprovedizin', [KaryawanController::class, 'aprovedizin']);
    Route::get('/{id}/batal', [KaryawanController::class, 'batalizin']);

    Route::get('/konfirmasidinas', [KaryawanController::class, 'konfirmasidinas']);
    Route::post('/aproveddinas', [KaryawanController::class, 'aproveddinas']);
    Route::get('/{id}/bataldinas', [KaryawanController::class, 'bataldinas']);

    Route::get('/konfirmasiubah', [KaryawanController::class, 'konfirmasiubah']);
    Route::post('/resetpassword/{nik}', [KaryawanController::class, 'resetPassword']);
});
