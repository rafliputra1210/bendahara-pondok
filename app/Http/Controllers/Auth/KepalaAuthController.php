<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KepalaAuthController extends Controller
{
    /**
     * Tampilkan form login Kepala Madrasah
     */
    public function showLoginForm()
    {
        // Jika sudah login sebagai kepala, langsung ke dashboard kepala
        if (Auth::check() && Auth::user()->role === 'kepala') {
            return redirect()->route('kepala.dashboard');
        }

        // Jika sedang login sebagai role lain (misal admin), logout dulu
        if (Auth::check() && Auth::user()->role !== 'kepala') {
            Auth::logout();
        }

        return view('auth.kepala-login');
    }

    /**
     * Proses login Kepala Madrasah
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Pastikan hanya role 'kepala' yang boleh lanjut
            if (Auth::user()->role === 'kepala') {
                return redirect()->route('kepala.dashboard');
            }

            // Kalau yang login bukan kepala, logout lagi
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akun ini bukan akun Kepala Madrasah.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Logout Kepala Madrasah
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Balik ke halaman pilihan login
        return redirect()->route('landing');
    }
}
