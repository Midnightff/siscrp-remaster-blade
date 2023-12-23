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
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 45);
            $table->text('descripcion', 200);
            $table->string('rutaImagen', 100);
            $table->decimal('precio', 10, 2)->default(0);
            $table->date('fechaInicio')->nullable();
            $table->date('fechaFinal')->nullable();
            $table->unsignedBigInteger('tratamiento_id')->nullable();
            $table->foreign('tratamiento_id')->references('id')->on('tratamientos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicaciones');
    }
};
