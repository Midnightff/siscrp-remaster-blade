<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    public function antecedentesMedicos()
    {
        return $this->hasMany(AntecedentesMedicos::class, 'paciente_id');
    }

    protected $fillable = [
        'nombres', 'apellidos', 'sexo', 'numeroTelefonico', 'fechaNacimiento', 'user_id'
    ];

    public static $rules = [
        'nombres' => 'required|max:45',
        'apellidos' => 'required|max:45',
        'sexo' => 'in:m,f',
        'numeroTelefonico' => 'required|max:12',
        'fechaNacimiento' => 'required|date',
        'user_id' => 'max:45',
        
    ];

    public static $customMessages = [
        'nombres.required' => 'Los nombres son obligatorios',
        'nombres.max' => 'Los nombres exceden la cantidad de :max caracteres.',
        'apellidos.required' => 'Los apellidos son obligatorios.',
        'apellidos.max' => 'Los appellidos exceden la cantidad de :max caracteres.',
        'sexo.in' => 'El genero debe ser (femenino) o (masculino).',
        'numeroTelefonico.required' => 'El numero de telefono es obligatorio.',
        'numeroTelefonico.max' => 'El numero de telefono excede la cantidad de :max caracteres.',
        'user_id.required' => 'El usuario es requerido.',
    ];
}
