<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            // dd(Auth::user());
            $request->session()->regenerate();

            // redirect sesuai role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('dashboard');
            }
            if (Auth::user()->role === 'kepala') {
                return redirect()->route('kepala.dashboard');
            }

            Auth::logout();
            return back()->withErrors([
                'email' => 'Role tidak dikenali',
            ]);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
