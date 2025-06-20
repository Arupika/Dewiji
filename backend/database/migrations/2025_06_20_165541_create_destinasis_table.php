<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('destinasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi');
            $table->string('gambar');
            $table->string('location');
            $table->json('kategori')->nullable(); // Contoh: ["Alam", "Petualangan"]
            $table->json('harga')->nullable(); // Contoh: {"Dewasa": "Rp 50.000", "Anak-anak": "Rp 25.000"}
            $table->string('jamOperasional');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destinasis');
    }
};
//
// This migration creates a 'destinasis' table with the following fields:
// - id: Primary key
// - nama: Name of the destination
// - deskripsi: Description of the destination
// - gambar: Image URL or path
// - location: Location of the destination
// - kategori: JSON field for categories (e.g., ["Alam", "Petualangan"])
// - harga: JSON field for prices (e.g., {"Dewasa": "Rp 50.000", "Anak-anak": "Rp 25.000"})
// - jamOperasional: Operational hours of the destination
// - timestamps: Created at and updated at timestamps
