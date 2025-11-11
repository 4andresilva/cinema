<?php

use App\Http\Controllers\Auth\UnifiedLoginController;
use App\Services\Api\GeneroService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (!auth()->check()) {
        return redirect('/auth/login');
    }

    $user = auth()->user();
    
    return match($user->role) {
        'admin' => redirect('/cinema-api'),
        'vendedor' => redirect('/cinema-api/filmes'),
        'cliente' => redirect('/cliente'),
        default => redirect('/auth/login'), // Fallback
    };
});


Route::prefix('auth')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [UnifiedLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [UnifiedLoginController::class, 'login']);
    });
    
    Route::post('/logout', [UnifiedLoginController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');
});


Route::prefix('api/totem')->middleware('auth')->group(function () {
    Route::get('/filmes', function () {
        Gate::authorize('viewAny', \App\Models\Totem\FilmeTotem::class);
        return \App\Models\Totem\FilmeTotem::all();
    });

    Route::get('/generos', function (GeneroService $generoService) {
        return $generoService->listar();
    });
});