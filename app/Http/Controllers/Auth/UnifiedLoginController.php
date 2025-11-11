<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UnifiedLoginController extends Controller
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
            $request->session()->regenerate();

            $user = Auth::user();
            
            /* dd($user->role); */

            // Redireciona baseado na role
            return match ($user->role) {
                'admin' => redirect()->intended('/cinema-api/'),
                'vendedor' => redirect()->intended('/cinema-api/filmes'),
                'cliente' => redirect()->intended('/cliente'),
                default => redirect('/'), // Fallback para usuários sem role
            };
        }

        throw ValidationException::withMessages([
            'email' => __('As credenciais fornecidas não correspondem aos nossos registros.'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/auth/login');
    }
}
