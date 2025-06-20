<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pakets', function (Blueprint $table) {
            $table->id();
            $table->json('destinasi')->nullable(); // Contoh: ["Candi Borobudur", "Svargabumi", ...]
            $table->json('gambar')->nullable(); // Bisa 1 atau lebih gambar
            $table->json('harga')->nullable(); // Nested JSON: jenis mobil => { lama, diskon }
            $table->json('termasuk')->nullable(); // Contoh: ["Mobil + Supir + BBM", ...]
            $table->json('tidak_termasuk')->nullable(); // Contoh: ["Parkir", "Tiket masuk", ...]
            $table->text('deskripsi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pakets');
    }
};
//
// This migration creates a 'pakets' table with the following fields:
// - id: Primary key
// - destinasi: JSON field for destinations (e.g., ["Candi Borobudur", "Svargabumi"])
// - gambar: JSON field for images (can store multiple images)
// - harga: JSON field for prices (nested structure with type of car and its details)
// - termasuk: JSON field for included items (e.g., ["Mobil + Supir + BBM"])
// - tidak_termasuk: JSON field for excluded items (e.g., ["Parkir", "Tiket masuk"])
// - deskripsi: Text description of the package
// - timestamps: Created at and updated at timestamps
//              