<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table ='reviews';
    protected $primaryKey = 'review_id';

    protected $fillable = [
        'comment', 'rating', 'review_type', 'booking_id'
    ];
}
