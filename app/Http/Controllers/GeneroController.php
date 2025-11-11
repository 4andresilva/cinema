<?php

namespace App\Http\Controllers;

use App\Services\Api\GeneroService;

class FilmeController extends Controller
{
    public function index(GeneroService $filmeService)
    {
        $filmes = $filmeService->listar();
        return response()->json($filmes);
    }
}

