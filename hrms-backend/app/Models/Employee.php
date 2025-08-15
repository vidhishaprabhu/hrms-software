<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'department',
        'designation',
        'date_of_joining',
        'gender',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
