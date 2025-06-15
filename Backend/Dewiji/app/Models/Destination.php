<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $table = 'destinations';

    protected $fillable = [
        'name',
        'location',
        'description',
        'image_url',
        'opening_hours',
        'ticket_info_1',
        'ticket_info_2',
    ];
}
