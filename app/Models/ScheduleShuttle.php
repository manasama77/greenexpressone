<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleShuttle extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'from_type',
        'from_id',
        'to_id',
        'vehicle_name',
        'vehicle_number',
        'time_departure',
        'is_active',
        'photo',
        'price',
        'driver_contact',
        'notes',
        'total_seat',
        'luggage_price',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
