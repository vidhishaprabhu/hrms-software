<?php

namespace App\Models;

use App\Models\LeaveBalance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    public function leaveBalance()
    {
        return $this->hasOne(LeaveBalance::class);
    }

}
