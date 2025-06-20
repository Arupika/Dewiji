<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'birthDate',
        'role',
        'gambar',
        'sex',
        'address',
        'password',
        'agreeTerms',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function gambar(): Attribute
    {
        return Attribute::make(
            get: fn ($gambar) => $gambar ? url('/storage/users/' . $gambar) : null
        );
    }
}



