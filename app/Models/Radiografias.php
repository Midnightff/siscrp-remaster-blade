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

    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class, 'tratamiento_id');
    }

    protected $fillable = [
        'nombreRadiografia', 'fechaRealizada', 'tratamiento_id', 'paciente_id'
    ];

    public static $rules = [
        // 'nombreRadiografia' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'fechaRealizada' => 'required|date',
        'tratamiento_id' => 'required',
        'paciente_id' => 'required',
    ];

    public static $customMessages = [
        // 'nombreRadiografia.image' => 'Debe ser una imagen.',
        // 'nombreRadiografia.mimes' => 'La imagen debe tener un formato válido (jpeg, png, jpg, gif, svg).',
        'fechaRealizada.required' => 'La fecha en la que se realiza la radiografia es obligatoria.',
        'tratamiento_id.required' => 'El tratamiento es obligatorio',
        'paciente_id.required' => 'El paciente es obligatorio.',
    ];
}
