<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntecedentesMedicos extends Model
{
    use HasFactory;

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    protected $fillable = [
        'hipertencionArterial',
        'cardiopatia',
        'diabetesMellitu',
        'problemaRenal',
        'problemaRespiratorio',
        'problemaHepatico',
        'problemaEndocrino',
        'problemaHemorragico',
        'alergiaMedicamentos',
        'embarazo',
        'otrosMedicamentosQueToma',
        'otrosDatos',
        'paciente_id'

    ];

    public static $rules = [
        'hipertencionArterial' => 'required',
        'cardiopatia' => 'required',
        'diabetesMellitu' => 'required',
        'problemaRenal' => 'required',
        'problemaRespiratorio' => 'required',
        'problemaHepatico' => 'required',
        'problemaEndocrino' => 'required',
        'problemaHemorragico' => 'required',
        'alergiaMedicamentos' => 'max:255',
        'embarazo' => 'required',
        'otrosMedicamentosQueToma' => 'max:255',
        'otrosDatos' => 'max:255',
        'paciente_id' => 'required'
    ];

    public static $customMessages = [
        'hipertencionArterial.required' => 'El campo de hipertension arterial es obligatorio.',
        'cardiopatia.required' => 'El campo de cardiopatia es obligatorio.',
        'diabetesMellitu.required' => 'El campo de diabetes mellitu es obligatorio.',
        'problemaRenal.required' => 'El campo de problema renal es obligatorio.',
        'problemaRespiratorio.required' => 'El campo de problema respiratorio es obligatorio.',
        'problemaHepatico.required' => 'El campo de problema hepatico es obligatorio.',
        'problemaEndocrino.required' => 'El campo de problema endocrino es obligatorio.',
        'problemaHemorragico.required' => 'El campo de problema hemorragico es obligatorio.',
        'alergiaMedicamentos.max' => 'El campo de alergia a medicamentos tiene mas de 255 caracteres',
        'embarazo.required' => 'El campo de embarazo es obligatorio.',
        'otrosMedicamentosQueToma.max' => 'El campo de Otro medicamentos tiene mas de 255 caracteres',
        'otrosDatos.max' => 'El campo de otros tiene mas de 255 caracteres',
        'paciente_id.required' => 'El campo Paciente es requerido'
    ];
}
