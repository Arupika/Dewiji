<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalOrder extends Model
{
    protected $table = 'rental_orders';

    protected $fillable = [
        'user_id',
        'car_id',
        'pickup_location',
        'pickup_date',
        'duration_days',
        'whatsapp_number',
        'notes',
        'status'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function car() {
        return $this->belongsTo(RentalCar::class, 'car_id');
    }
}
// This code defines a RentalOrder model in a Laravel application.
// It specifies the table name and fillable attributes for mass assignment.