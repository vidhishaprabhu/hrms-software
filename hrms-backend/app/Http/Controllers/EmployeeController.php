<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }
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
    public function getEmployees(Request $request){
        $userId=auth()->id();
        $employee = Employee::where('user_id', $userId)->first();

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        return response()->json([
            'employee_id' => $employee->employee_id,
            'first_name'  => $employee->first_name,
            'last_name'   => $employee->last_name,
            'email'=>$employee->email,
            'status'=>$employee->status
        ]);
    }

}
