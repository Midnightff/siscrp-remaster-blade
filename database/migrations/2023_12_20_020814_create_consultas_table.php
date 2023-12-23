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
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->enum('estado', ['e', 'c', 'a'])->default('e');
            $table->date('fechaConsulta');
            $table->string('observacion', 100);
            $table->decimal('costoConsulta', 8, 2);
            $table->unsignedBigInteger('cita_id');
            $table->foreign('cita_id')->references('id')->on('citas');
            $table->unsignedBigInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('doctores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
