<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cleaner extends Model
{
    use HasFactory;
    protected $table ='cleaners';
    protected $primaryKey = 'cleaner_id';

    protected $fillable = [
        'age', 'address', 'user_id'
    ];
}
