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
        Schema::create('salas', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->foreignUuid('cinema_id')->references('id')->on('cinemas')->onupdate('cascade')->ondelete('cascade');
            $table->string('nome', 150)->index();
            $table->integer('capacidade')->unsigned();
            $table->enum('tipo', ['2D', '3D', 'IMAX']);
            $table->boolean('disponivel')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salas');
    }
};
