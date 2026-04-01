<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Jika user belum login, atau role-nya tidak cocok dengan yang diminta di route
        if (!Auth::check() || Auth::user()->role !== $role) {
            // Tolak akses dengan pesan 403 Forbidden
            abort(403, 'Akses Ditolak! Anda tidak memiliki izin ke halaman ini.');
        }

        // Jika cocok, silakan lewat
        return $next($request);
    }
}