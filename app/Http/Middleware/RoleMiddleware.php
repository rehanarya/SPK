<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware penjaga hak akses berbasis peran (admin / petugas).
 *
 * Penggunaan di routes:
 *   ->middleware('role:admin')
 *   ->middleware('role:petugas')
 *   ->middleware('role:admin,petugas')   // salah satu diterima
 */
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $pengguna = Auth::user();

        foreach ($roles as $role) {
            if ($pengguna->peran === $role) {
                return $next($request);
            }
        }

        abort(403, 'Akses ditolak. Anda tidak memiliki hak untuk halaman ini.');
    }
}
