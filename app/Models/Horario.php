<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'calendario_id',
        'user_id',
        'type',
        'dia_entrada',
        'dia_salida'
    ];

    //Por que un horario pertenece a un user y a un calendario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function calendario()
    {
        return $this->belongsTo(Calendario::class);
    }
}
