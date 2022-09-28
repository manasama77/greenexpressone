<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charter extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'from_type',
        'from_id',
        'to_id',
        'vehicle_name',
        'vehicle_number',
        'is_available',
        'photo',
        'price',
        'driver_contact',
        'notes',
    ];
}
