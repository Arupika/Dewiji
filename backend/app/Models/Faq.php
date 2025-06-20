<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'answer',
        'category',
    ];
}
// This model represents a Frequently Asked Question (FAQ) with fields for the question title, answer, and category.
// The 'fillable' property specifies which attributes can be mass assigned.
// The 'category' field can be used to group FAQs into different sections, such as 'car-rental', 'booking', etc.
// This model can be used to manage FAQs in a web application, allowing for easy retrieval and display of frequently asked questions and their answers.
