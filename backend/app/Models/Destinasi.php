<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Destinasi extends Model
{
    use HasFactory;

    protected $fillable = [
    'nama', 
    'deskripsi', 
    'location', 
    'kategori',
    'harga', 
    'jamOperasional', 
    'gambar'
];


    protected $casts = [
        'kategori' => 'array',
        'harga' => 'array',
    ];

    protected function gambar(): Attribute
    {
        return Attribute::make(
            get: fn ($gambar) => $gambar ? url('/storage/destinasis/' . $gambar) : null
        );
    }
}
// This model represents a travel destination with fields for name, description, images, location, categories, prices, and operational hours.
// The 'kategori' and 'harga' fields are cast to arrays for easier manipulation.
// The 'fillable' property specifies which attributes can be mass assigned.
// The 'gambar' attribute is accessed through a custom accessor that returns the full URL to the image if it exists, or null if it does not.

