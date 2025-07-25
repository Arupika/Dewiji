<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->date('birthDate')->nullable();
            $table->string('role')->default('user'); // Default role is 'user'
            $table->string('gambar')->nullable(); // Optional profile picture
            $table->string('sex')->nullable(); //
            $table->text('address')->nullable();
            $table->string('password');
            $table->boolean('agreeTerms')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

