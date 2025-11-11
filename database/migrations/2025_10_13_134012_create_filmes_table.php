<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('filmes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('titulo',255);
            $table->longText('sinopse',255);
            $table->integer('duracao_min')->unsigned();
            $table->string('genero',255);
            $table->string('classificacao',255);
            $table->string('poster',1000);
            $table->timestamps();

            $table->index('titulo');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filmes');
    }
};
