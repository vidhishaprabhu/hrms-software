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
}
