<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute; // PENTING: Tambahkan ini untuk accessor gambar
use Illuminate\Support\Facades\URL; // PENTING: Tambahkan ini untuk accessor gambar

class Paket extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', // <-- BARU: Tambahkan 'nama' ke fillable
        'destinasi',
        'gambar', // Pastikan ini di fillable untuk penyimpanan nama file
        'harga',
        'termasuk',
        'tidak_termasuk',
        'deskripsi',
    ];

    protected $casts = [
        'destinasi'      => 'array', // Cast ke array untuk field JSON destinasi
        'harga'          => 'array', // Cast ke array untuk field JSON harga
        'termasuk'       => 'array', // Cast ke array untuk field JSON termasuk
        'tidak_termasuk' => 'array', // Cast ke array untuk field JSON tidak_termasuk
        // 'gambar'         => 'string', // Tidak perlu di-cast jika accessor gambar() sudah mengurusnya
    ];

    /**
     * Accessor untuk gambar: Mengembalikan URL lengkap gambar paket.
     * Asumsi gambar disimpan di storage/app/public/pakets
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function gambar(): Attribute
    {
        return Attribute::make(
            get: fn ($gambar) => $gambar ? URL::to('/storage/pakets/' . $gambar) : null,
        );
    }
}