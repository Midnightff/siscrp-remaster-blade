<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odontograma extends Model
{
    use HasFactory;

    protected $table = 'odontograma';

    protected $fillable = [
        'numeroDiente',
        'estadoDiente',
        'seccionDiente',
        'observaciones',
        'paciente_id',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
}
