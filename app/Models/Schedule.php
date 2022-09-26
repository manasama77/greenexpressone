<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'from_id',
        'from_table',
        'to_id',
        'to_table',
        'vehicle_id',
        'datetime_departure',
        'datetime_arrival',
        'schedule_type',
        'is_active',
        'photo',
        'normal_price',
        'driver_contact',
        'notes',
    ];

    protected $hidden = [
        'updated_at'
    ];

    public function vehicles()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }
}
