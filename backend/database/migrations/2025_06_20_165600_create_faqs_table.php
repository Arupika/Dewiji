<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('answer');
            $table->string('category'); // Contoh: 'car-rental'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
//
// This migration creates a 'faqs' table with the following fields:
// - id: Primary key
// - title: The question or title of the FAQ
// - answer: The answer or explanation for the FAQ
// - category: The category of the FAQ (e.g., 'car-rental', 'booking', etc.)
// - timestamps: Created at and updated at timestamps
