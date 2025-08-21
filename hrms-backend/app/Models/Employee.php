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
        'blood_group',
        'city',
        'address',
        'gender',
        'status',
        'father_name',
        'date_of_birth',
        'marital_status','physically_challenged',
        'state',
        'pin',
        'confirmation_date',
        'employee_type',
        'probation_period_days'
        
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
