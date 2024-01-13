<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $table="doctores";
    protected $fillable = [
        'nombres',
        'apellidos',
        'sexo',
        'numeroTelefonico',
        'user_id',
        'tratamiento_id',
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class);
    }

    public function horarios()
    {
        return $this->hasMany(HorarioDoctor::class, 'doctor_id');
    }
}
