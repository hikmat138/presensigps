<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
   public function Proseslogin(Request $request)
   {
    if(Auth::guard('pegawai')->attempt(['nik' => $request->nik, 'password' => $request->password])){
        return redirect('/dashboard');
    } else {
        return redirect('/')->with(['Warning' => 'NIK atau Password salah']);
    }   
   }
   public function logout()
   {
    if  (auth::guard('pegawai')->check()){
        auth::guard('pegawai')->logout();
    }
    return redirect('/');
   }

    // Proses login admin
    public function Prosesloginadmin(Request $request)
{
    if (Auth::guard('user')->attempt([
        'email' => $request->email,
        'password' => $request->password
    ])) {
        return redirect('/panel/dashboardadmin');
    } else {
        return redirect('/panel')->with(['Error' => 'Email atau Password salah']);
    }
}

public function logoutadmin()
{
    if (Auth::guard('user')->check()) {
        Auth::guard('user')->logout();
    }
    return redirect('/panel');
}

}
