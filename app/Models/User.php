<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'country_id',
        'state_id',
        'city_id',
        'address',
        'postal_code'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //Indicando que el usuario pertenece a un pais
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    //El usuario va a tener multiples calendarios
    public function calendarios()
    {
        return $this->belongsToMany(Calendario::class);
    }

    //Puede pertenecer a multiples departamentos
    public function departamentos()
    {
        return $this->belongsToMany(Departamento::class);
    }

    //Puede tener multiples vacaciones
    public function vacations()
    {
        return $this->hasMany(Vacation::class);
    }

    //Puede tener multiples horarios
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}
