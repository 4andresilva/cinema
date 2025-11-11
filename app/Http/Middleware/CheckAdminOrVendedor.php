<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminOrVendedor
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || !in_array($user->role, ['admin', 'vendedor'])) {
            return redirect('/auth/login');
            /* abort(403, 'Acesso negado. Apenas administradores e vendedores.'); */
        } else if ($user->role === 'cliente') {
            return redirect('/cliente');
        }

        return $next($request);
    }
}
