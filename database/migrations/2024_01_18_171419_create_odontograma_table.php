<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('odontograma', function (Blueprint $table) {
            $table->id();
            $table->integer('numeroDiente');
            $table->char('estadoDiente', 1)->default('b');
            $table->set('seccionDiente', ['1', '2', '3', '4', '5']);
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('paciente_id');
            $table->timestamps();
    
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('odontograma');
    }
};
