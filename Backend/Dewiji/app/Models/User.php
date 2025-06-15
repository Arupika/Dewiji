<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // kalau pakai token login

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
/**
 * The attributes that are mass assignable.
 *
 * @var array
 */

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'birth_date',
        'address',
        'role',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // Relasi ke order paket liburan
    public function holidayOrders()
    {
        return $this->hasMany(HolidayPackageOrder::class);
    }

    // Relasi ke order rental mobil
    public function rentalOrders()
    {
        return $this->hasMany(RentalOrder::class);
    }
}
