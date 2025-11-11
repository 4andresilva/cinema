<?php

namespace App\Services\Api;

use App\Models\Totem\FilmeTotem;
use Illuminate\Support\Collection;

class FilmeService extends BaseService
{
    /**
     * Retorna todos os filmes
     */
    public function listar(): Collection
    {
        return FilmeTotem::on('pgsql_totem')->get();
    }

    /**
     * Retorna um filme específico
     */
    public function buscarPorId(int $id): ?FilmeTotem
    {
        return FilmeTotem::on('pgsql_totem')->find($id);
    }

    /**
     * Cria um novo filme
     */
    public function criar(array $dados): FilmeTotem
    {
        return FilmeTotem::on('pgsql_totem')->create($dados);
    }

    /**
     * Atualiza um filme existente
     */
    public function atualizar(int $id, array $dados): ?FilmeTotem
    {
        $filme = FilmeTotem::on('pgsql_totem')->find($id);
        if (!$filme) {
            return null;
        }

        $filme->update($dados);
        return $filme;
    }

    /**
     * Exclui um filme
     */
    public function deletar(int $id): bool
    {
        $filme = FilmeTotem::on('pgsql_totem')->find($id);
        return $filme?->delete() ?? false;
    }
}
