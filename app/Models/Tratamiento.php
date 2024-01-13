<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombreTratamiento', 'descripcion', 'nombreImagen', 'precio', 'estado'
    ];

    // Validaciones
    public static $rules = [
        'nombreTratamiento' => 'required|max:40|unique:tratamientos,nombreTratamiento',
        'descripcion' => 'required',
        'imagen' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'precio' => 'numeric|between:0,999999.99',
        'estado' => 'in:a,i',
    ];

    public static $customMessages = [
        'nombreTratamiento.required' => 'El nombre del tratamiento es obligatorio.',
        'nombreTratamiento.max' => 'El nombre del tratamiento no puede tener más de :max caracteres.',
        'nombreTratamiento.unique' => 'El nombre del tratamiento ya existe. Por favor, elige otro.',
        'descripcion.required' => 'La descripción del tratamiento es obligatoria.',
        'imagen.image' => 'La imagen debe ser de tipo imagen.',
        'imagen.mimes' => 'La imagen debe tener un formato válido (jpeg, png, jpg, gif, svg).',
        'imagen.max' => 'La imagen no debe ser más grande que :max kilobytes.',
        'precio.numeric' => 'El precio debe ser un valor numérico.',
        'precio.between' => 'El precio debe estar entre :min y :max.',
        'estado.in' => 'El estado debe ser "a" (activo) o "i" (inactivo).',
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function doctores()
    {
        return $this->hasMany(Doctor::class);
    }
}
