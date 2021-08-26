<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;
    protected $table ='prices';
    protected $primaryKey = 'price_id';

    protected $fillable = [
        'property_type', 'price', 'number_of_cleaner'
    ];
}
