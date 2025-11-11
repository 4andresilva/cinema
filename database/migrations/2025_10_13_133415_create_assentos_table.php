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
        Schema::create('assentos', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->foreignUuid('sala_id')->references('id')->on('salas')->onupdate('cascade')->ondelete('cascade');
            $table->string('fila',5);
            $table->integer('numero')->unsigned();
            $table->unique(['fila', 'numero', 'sala_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assentos');
    }
};
