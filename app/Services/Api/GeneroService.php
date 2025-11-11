<?php

namespace App\Services\Api;

use App\Services\Api\BaseService;
use Illuminate\Support\Facades\Http;

class GeneroService extends BaseService
{
    protected string $endpoint = 'generos';

    /**
     * Retorna todos os gêneros (GET)
     */
    public function listar()
    {
        $response = Http::get("{$this->baseUrl}/{$this->endpoint}");

        if ($response->failed()) {
            throw new \Exception('Erro ao buscar genero da API externa');
        }

        return $response->json();
    }

    /**
     * Retorna um gênero específico (GET)
     */
    public function buscarPorId(int $id)
    {
        $response = Http::get("{$this->baseUrl}/{$this->endpoint}/{$id}");

        if ($response->failed()) {
            throw new \Exception("Erro ao buscar o gênero #{$id}");
        }

        return $response->json();
    }

    /**
     * Cria um novo gênero (POST)
     */
    public function criar(array $dados)
    {
        $response = Http::post("{$this->baseUrl}/{$this->endpoint}", $dados);

        if ($response->failed()) {
            throw new \Exception('Erro ao criar gêneros na API externa');
        }

        return $response->json();
    }

    /**
     * Atualiza um gênero existente (PUT)
     */
    public function atualizar(int $id, array $dados)
    {
        $response = Http::put("{$this->baseUrl}/{$this->endpoint}/{$id}", $dados);

        if ($response->failed()) {
            throw new \Exception("Erro ao atualizar o gênero #{$id}");
        }

        return $response->json();
    }

    /**
     * Exclui um gênero (DELETE)
     */
    public function deletar(int $id)
    {
        $response = Http::delete("{$this->baseUrl}/{$this->endpoint}/{$id}");

        if ($response->failed()) {
            throw new \Exception("Erro ao excluir o gênero #{$id}");
        }

        return $response->json();
    }
}
