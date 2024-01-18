<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;
    protected $table = 'consultas';

    protected $fillable = [
        'estado', 'observacion', 'costoConsulta', 'cita_id',
    ];

    // Relación con la tabla "citas"
    public function cita()
    {
        return $this->belongsTo(Cita::class, 'cita_id');
    }
}
