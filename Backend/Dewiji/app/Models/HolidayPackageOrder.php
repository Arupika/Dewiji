<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HolidayPackageOrder extends Model
{
    protected $table = 'holiday_packages_orders';

    protected $fillable = [
        'user_id',
        'package_id',
        'car_type',
        'tour_date',
        'full_name',
        'whatsapp_number',
        'notes',
        'status'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function package() {
        return $this->belongsTo(HolidayPackage::class, 'package_id');
    }
}
// This code defines a HolidayPackageOrder model in a Laravel application.
// It specifies the table name and fillable attributes for mass assignment, and establishes relationships with the User and HolidayPackage models.