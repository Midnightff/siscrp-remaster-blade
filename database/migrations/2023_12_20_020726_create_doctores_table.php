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
        Schema::create('doctores', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 45);
            $table->string('apellidos', 45);
            $table->enum('sexo', ['m', 'f']);
            $table->string('numeroTelefonico', 12);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('tratamiento_id')->nullable();
            $table->foreign('tratamiento_id')->references('id')->on('tratamientos');
            $table->timestamps();
            $table->unique('tratamiento_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctores');
    }
};
