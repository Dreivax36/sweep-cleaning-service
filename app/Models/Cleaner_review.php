<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cleaner_review extends Model
{
    use HasFactory;
    protected $table ='cleaner_reviews';
    protected $primaryKey = 'cleaner_reviews_id';
}