<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table ='bookings';
    protected $primaryKey = 'booking_id';

    protected $fillable = [
        'customer_id', 'service_id', 'property_type', 'schedule_date', 'schedule_time', 'mode_of_payment'.'status', 'is_paid'
    ];

}
