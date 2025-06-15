<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayPackage extends Model
{
    use HasFactory;

    protected $table = 'holiday_packages';

    protected $fillable = [
        'name',
        'description',
        'image_url',
        'rating',
        'duration',
        'include',
        'exclude',
    ];
}
// This code defines a HolidayPackage model in a Laravel application.
// It uses the HasFactory trait for factory-based testing and specifies the table name and fillable attributes for mass assignment.