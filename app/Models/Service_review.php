<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service_review extends Model
{
    use HasFactory;
    protected $table ='service_reviews';
    protected $primaryKey = 'service_reviews_id';

    protected $fillable = [
        'service_name', 'review_id'
    ];
}
