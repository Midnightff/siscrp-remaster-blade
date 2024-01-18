<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Radiografias extends Model
{
    use HasFactory;

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    protected $fillable = [
        'nombreRadiografia', 'fechaRealizada', 'tratamiento_id', 'paciente_id'
    ];

    public static $rules = [
        'nombreRadiografia'=> 'required|max:100|unique:radiografias,nombreRadiografia',
        'fechaRealizada' => 'required|date',
        'tratamiento_id' => 'required',
        'paciente_id' => 'required',
    ];

    public static $customMessages = [
        'nombreRadiografia.required' => 'La imagen de la radiografia es obligatoria',
        'nombreRadiografia.max' => 'La ruta excede el limite de caracteres.',
        'nombreRadiografia.unique' => 'Ya existe una radiografia con ese nombre.',
        'fechaRealizada.required' => 'La fecha en la que se realiza la radiografia es obligatoria.',
        'tratamiento_id.required' => 'El tratamiento es obligatorio',
        'paciente_id.required' => 'El paciente es obligatorio.',
    ];
}
