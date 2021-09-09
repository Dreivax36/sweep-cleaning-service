<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assigned_cleaner extends Model
{
    use HasFactory;
    protected $table ='assigned_cleaners';
    protected $primaryKey = 'assigned_cleaner_id';

    protected $fillable = [
        'status', 'cleaner_id', 'booking_id'
    ];
}
