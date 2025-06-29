<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute; // Tetap pakai ini untuk accessor
use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- PENTING: Tambahkan ini
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory; // <-- PENTING: Tambahkan HasFactory di sini

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
        'agreeTerms', // Pastikan ini ada di fillable jika disimpan ke DB
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime', // Tambahkan ini jika kamu punya kolom email_verified_at
        'password' => 'hashed', // <-- PENTING: Gunakan 'hashed' jika Laravel 9+
        'birthDate' => 'date',   // <-- PENTING: Cast untuk tanggal lahir
        'agreeTerms' => 'boolean', // <-- PENTING: Cast untuk boolean (jika kolom ada di DB)
    ];

    /**
     * Get the user's profile picture URL.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function gambar(): Attribute
    {
        return Attribute::make(
            get: fn ($gambar) => $gambar ? url('/storage/users/' . $gambar) : null,
        );
    }
}