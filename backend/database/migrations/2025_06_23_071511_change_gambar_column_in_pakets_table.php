<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pakets', function (Blueprint $table) {
            $table->string('gambar')->nullable()->change(); // ubah dari json ke string
        });
    }

    public function down(): void
    {
        Schema::table('pakets', function (Blueprint $table) {
            $table->json('gambar')->nullable()->change(); // balik ke json jika rollback
        });
    }
};
