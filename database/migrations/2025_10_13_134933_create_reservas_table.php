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
        Schema::create('reservas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('cliente_id')->references('id')->on('clientes')->onupdate('cascade')->ondelete('cascade');
            $table->foreignUuid('sessao_id')->references('id')->on('sessoes')->onupdate('cascade')->ondelete('cascade');
            $table->enum('status', ['pendente', 'reservado', 'cancelado', 'pago']);
            $table->index(['id']);
            $table->unique(['id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
