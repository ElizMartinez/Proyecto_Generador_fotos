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
        Schema::create('coleccion', function (Blueprint $table) {
            $table->id('id_coleccion');
            $table->string('nombre_coleccion');
            $table->unsignedBigInteger('proyecto_id');
            $table->foreign('proyecto_id')
                  ->references('id_proyecto')
                  ->on('proyectos')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coleccion');
    }
};