<?php

namespace App\Jobs;

use App\Filament\Exports\FilmeTotemExporter;
use App\Models\Totem\FilmeTotem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class ProcessaExportacaoFilmes implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // 1. Buscar os dados
        $filmes = FilmeTotem::all(['id', 'titulo', 'ano', 'genero']); // Ajuste os campos conforme necessário

        // 2. Gerar conteúdo CSV
        $csv = $this->gerarCsv($filmes);

        // 3. Salvar no disco (ex: storage/app/exports/filmes.csv)
        Storage::put('exports/filmes.csv', $csv);
    }

    private function gerarCsv($collection): string
    {
        $handle = fopen('php://temp', 'r+');

        // Cabeçalhos
        fputcsv($handle, ['ID', 'Título', 'Ano', 'Gênero']);

        foreach ($collection as $filme) {
            fputcsv($handle, [
                $filme->id,
                $filme->titulo,
                $filme->ano,
                $filme->genero,
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return $csv;
    }
}
