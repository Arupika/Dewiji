<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Mobil extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'harga12jam',
        'kapasitas',
        'fitur',
        'termasuk',
        'gambar',
    ];

    protected $casts = [
        'fitur' => 'array',
        'termasuk' => 'array',
    ];

    protected function gambar(): Attribute
    {
        return Attribute::make(
            get: fn ($gambar) => $gambar ? url('/storage/mobils/' . $gambar) : null
        );
    }
}

