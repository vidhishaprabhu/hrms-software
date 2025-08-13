<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'attendance_date',
        'check_in',
        'check_out',
        'status',
        'note',
        'user_id', // Added user_id to fillable attributes
    ];
    protected $casts = [
    'check_in' => 'datetime',
    'check_out' => 'datetime',
];


    // Define the relationship with Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
