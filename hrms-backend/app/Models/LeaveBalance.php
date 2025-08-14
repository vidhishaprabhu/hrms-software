<?php

namespace App\Models;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveBalance extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'employee_id',
        'bereavement_leave',
        'annual_leave',
        'restricted_holiday',
        'work_from_home',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
