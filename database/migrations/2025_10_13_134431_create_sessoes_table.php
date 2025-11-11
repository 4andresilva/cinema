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
        Schema::create('sessoes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('filme_id')->references('id')->on('filmes')->onupdate('cascade')->ondelete('cascade');
            $table->foreignUuid('sala_id')->references('id')->on('salas')->onupdate('cascade')->ondelete('cascade');
            $table->dateTime('data_hora')->index();
            $table->decimal('preco', 10,2)->unsigned();
            $table->boolean('disponivel')->default(true);
            
            $table->index(['id']);
            $table->unique(['id', 'sala_id', 'data_hora']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessoes');
    }
};
