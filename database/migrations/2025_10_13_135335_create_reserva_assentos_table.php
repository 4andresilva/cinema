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
        Schema::create('reserva_assentos', function (Blueprint $table) {
            $table->foreignUuid('reserva_id')->references('id')->on('reservas')->onupdate('cascade')->ondelete('cascade');
            $table->foreignUuid('assento_id')->references('id')->on('assentos')->onupdate('cascade')->ondelete('cascade');  
            
            $table->primary(['reserva_id', 'assento_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserva_assentos');
    }
};
