<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if(Auth::check()) {
            return redirect('/admin/transactions');
        }
        return view("auth.login");
    }
    public function authenticate($request Request)
    {
        $credentials = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"],
        ]);
        $remember = $request->boolean('remember');
        if(Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/transactions')->with("success" => "Selamat data Seller Center " . Auth::user()->name . " !");
        }
        return back()->withErrors(['email' => 'kredensial tidak cocok, coba periksa kembali email dan kata sandi !'])->onlyInput("email");
    }

    public function logout($request Request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('status' => "Berhasil Logout, Ruang Seller Center sudah dikunci kembali !");
    }

}
