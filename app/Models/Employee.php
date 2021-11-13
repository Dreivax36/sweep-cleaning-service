<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table ='employees';
    protected $primaryKey = 'employee_id';

    protected $fillable = [
        'full_name', 'email', 'contact_number', 'birthday', 'department', 'position', 'password'
    ];
}
