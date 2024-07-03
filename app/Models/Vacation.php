<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    use HasFactory;

    protected $fillable = [
        'calendario_id',
        'user_id',
        'dia',
        'type'
    ];

    //La relacion inversa porque un usuario va a tener multiples vacaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //La relacion porque vacaciones va a pertener a un calendario
    public function calendario()
    {
        return $this->belongsTo(Calendario::class);
    }
}
