<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // ✅ JIKA BELUM LOGIN → KE LOGIN
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // ✅ AMBIL USER
        $user = Auth::user();

        // ✅ CEK ROLE
        if (!in_array($user->role, $roles)) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}
