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
        'id',
        'schedule_id',
        'from_master_area_name',
        'from_master_sub_area_name',
        'to_master_area_name',
        'to_master_sub_area_name',
        'vehicle_name',
        'vehicle_number',
        'datetime_departure',
        'schedule_type',
        'user_id',
        'qty_adult',
        'qty_baby',
        'special_request',
        'flight_number',
        'notes',
        'luggage_qty',
        'luggage_price',
        'extra_price',
        'voucher_id',
        'promo_price',
        'base_price',
        'total_price',
        'booking_status',
        'payment_status',
        'payment_method',
        'payment_token',
        'total_payment',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];
}
