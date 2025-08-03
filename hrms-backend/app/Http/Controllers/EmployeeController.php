<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function totalEmployees()
    {
        $count = Employee::count();
        return response()->json([
            'total_employees' => $count
        ]);
    }
    public function getNewJoineesThisMonth(){
        $newJoinees = Employee::whereMonth('date_of_joining', now()->month)
            ->whereYear('date_of_joining', now()->year)
            ->count();
            
        return response()->json([
            'new_joinees' => $newJoinees
        ]);

    }

}
