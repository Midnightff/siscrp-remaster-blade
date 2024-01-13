<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicaciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo', 'descripcion', 'rutaImagen', 'precio', 'fechaInicio', 'fechaFinal', 'tratamiento_id'
    ];

    public static $rules = [
        'titulo' => 'required|max:45|unique:publicaciones,titulo',
        'descripcion' => 'required',
        'rutaImagen' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'precio' => 'numeric|between:0,999999.99',
        'fechaInicio' => 'required|date',
        'fechaFinal' => 'required|date',
        'tratamiento_id' => 'numeric'
    ];

    public static $customMessages = [
        'titulo.required' => 'El titulo de la publicacion es requerido.',
        'titulo.max' => 'EL titulo no puede tener más de :max caracteres.',
        'titulo.unique' => 'El titulo ya está registrado, por favor, escoja otro.',
        'descripcion.required' => 'La descripcion de la publicacion es necesaria.',
        'rutaImagen.image' => 'La imagen debe ser de tipo imagen.',
        'rutaImagen.mimes' => 'La imagen debe tener un formato válido (jpeg, png, jpg, gif, svg).',
        'rutaImagen.max' => 'La imagen no debe ser más grande que :max kilobytes.',
        'fechaInicio.required' => 'La fecha de inicio es obligatoria.',
        'fechaFinal.required' => 'La fecha Final es obligatoria.',
    ];
}
