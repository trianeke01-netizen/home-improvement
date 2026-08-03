<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * $roles = daftar role yang diizinkan mengakses rute ini
     * Contoh pemakaian di routes: ->middleware('role:admin')
     * atau untuk beberapa role: ->middleware('role:admin,teknisi')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // Kalau role user tidak termasuk yang diizinkan, tolak akses
        if (!$user || !in_array($user->role_user, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}