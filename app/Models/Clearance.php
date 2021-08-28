<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clearance extends Model
{
    use HasFactory;
    protected $table ='clearances';
    protected $primaryKey = 'clearance_id';

    protected $fillable = [
        'requirement', 'description', 'cleaner_id'
    ];
}
