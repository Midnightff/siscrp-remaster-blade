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
        Schema::create('antecedentes_medicos', function (Blueprint $table) {
            $table->id();
            $table->boolean('hipertencionArterial');
            $table->boolean('cardiopatia');
            $table->boolean('diabetesMellitu');
            $table->boolean('problemaRenal');
            $table->boolean('problemaRespiratorio');
            $table->boolean('problemaHepatico');
            $table->boolean('problemaEndocrino');
            $table->boolean('problemaHemorragico');
            $table->string('alergiaMedicamentos', 255)->nullable();
            $table->boolean('embarazo');
            $table->string('otrosMedicamentosQueToma', 255)->nullable();
            $table->text('otrosDatos', 255)->nullable();
            $table->unsignedBigInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antecedentes_medicos');
    }
};
