<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'schedule_id',
        'from_id',
        'from_table',
        'from_name',
        'to_id',
        'to_table',
        'to_name',
        'vehicle_id',
        'vehicle_name',
        'vehicle_number',
        'datetime_departure',
        'datetime_arrival',
        'schedule_type',
        'user_id',
        'qty_adult',
        'qty_baby',
        'is_extra',
        'flight_number',
        'notes',
        'luggage_qty',
        'luggage_price',
        'extra_price',
        'voucher_id',
        'promo_price',
        'total_price',
        'booking_status',
        'payment_method',
        'payment_token',
        'payment_status',
        'total_payment',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];
}
