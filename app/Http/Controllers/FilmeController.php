<?php

namespace App\Http\Controllers;

use App\Services\Api\FilmeService;

class FilmeController extends Controller
{
    public function index(FilmeService $filmeService)
    {
        $filmes = $filmeService->listar();
        return response()->json($filmes);
    }
}

