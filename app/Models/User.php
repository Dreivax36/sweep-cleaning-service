<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $table ='users';
    protected $primaryKey = 'user_id';

    protected $fillable = ["full_name", "email", "password", "contact_number", "profile_picture", "account_status", "user_type"];

}
