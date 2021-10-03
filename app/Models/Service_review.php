<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service_review extends Model
{
    use HasFactory;
    protected $table ='service_reviews';
    protected $primaryKey = 'service_review_id';

    protected $fillable = [
        'service_id', 'comment', 'rate', 'review_id'
    ];
}
