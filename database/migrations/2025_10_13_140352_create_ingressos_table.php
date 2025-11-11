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
        Schema::create('ingressos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('venda_id')->references('id')->on('vendas')->onupdate('cascade')->ondelete('cascade');
            $table->foreignUuid('assento_id')->references('id')->on('assentos')->onupdate('cascade')->ondelete('cascade');
            $table->foreignUuid('sessao_id')->references('id')->on('sessoes')->onupdate('cascade')->ondelete('cascade');
            $table->foreignUuid('reserva_id')->references('id')->on('reservas')->onupdate('cascade')->ondelete('cascade');
            
            $table->decimal('preco_pago', 10,2);
            $table->enum('status', ['emitido', 'cancelado', 'usado'])->default('emitido');
            $table->string('codigo',100);

            $table->unique(['id', 'codigo']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingressos');
    }
};
