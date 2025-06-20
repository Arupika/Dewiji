<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Paket extends Model
{
    use HasFactory;

    protected $fillable = [
        'destinasi',
        'gambar',
        'harga',
        'termasuk',
        'tidak_termasuk',
        'deskripsi',
    ];

    protected $casts = [
        'destinasi' => 'array',
        'gambar' => 'array',
        'harga' => 'array',
        'termasuk' => 'array',
        'tidak_termasuk' => 'array',
    ];

    protected function gambar(): Attribute
    {
        return Attribute::make(
            get: fn ($gambar) => is_array($gambar)
                ? array_map(fn($img) => url('/storage/pakets/' . $img), $gambar)
                : [],
        );
    }
}

// This model represents a travel package with fields for destinations, images, prices, included and excluded items, and a description.
// The 'destinasi', 'gambar', 'harga', 'termasuk', and 'tidak_termasuk' fields are cast to arrays for easier manipulation.
// The 'fillable' property specifies which attributes can be mass assigned.
// The 'casts' property ensures that the specified attributes are treated as arrays when accessed or modified.
// This allows for flexible handling of complex data structures, such as multiple destinations, images, and pricing details.
