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
        Schema::create('fotos', function (Blueprint $table) {
            $table->id('id_fotos');
            $table->string('titulo_foto', 255);
            $table->text('descripcion_foto');
            $table->text('pie_foto')-> nullable();
            $table->unsignedBigInteger('coleccion_id');
            $table->foreign('coleccion_id')
                  ->references('id_coleccion')
                  ->on('coleccion')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->string('path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fotos');
    }
};