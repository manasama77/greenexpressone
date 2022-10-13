<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Charter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'from_type',
        'from_master_area_id',
        'from_master_sub_area_id',
        'to_master_area_id',
        'to_master_sub_area_id',
        'vehicle_name',
        'vehicle_number',
        'is_available',
        'photo',
        'price',
        'driver_contact',
        'notes',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
