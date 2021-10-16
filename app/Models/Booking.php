<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Booking extends Model
{
    use Notifiable;
    protected $table ='bookings';
    protected $primaryKey = 'booking_id';

    protected $fillable = [
        'customer_id', 'service_id', 'property_type', 'schedule_date', 'schedule_time', 'mode_of_payment'.'status', 'is_paid', 'address_id'
    ];
}
