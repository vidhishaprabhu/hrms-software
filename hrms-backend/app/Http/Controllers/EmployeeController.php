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
            'status'=>$employee->status,
            'phone_number'=>$employee->phone_number,
            'department'=>$employee->department,
            'designation'=>$employee->designation,
            'date_of_joining'=>$employee->date_of_joining,
            'blood_group'=>$employee->blood_group,
            'city'=>$employee->city,
            'address'=>$employee->address,
            'gender'=>$employee->gender,
            'father_name'=>$employee->father_name,
            'date_of_birth'=>$employee->date_of_birth,
            'marital_status'=>$employee->marital_status,
            'physically_challenged'=>$employee->physically_challenged,
            'state'=>$employee->state,
            'pin'=>$employee->pin,
            'confirmation_date'=>$employee->confirmation_date,
            'employee_type'=>$employee->employee_type,
            'probation_period_days'=>$employee->probation_period_days
        ]);
    }
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json($employee);
    }
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $employee->update([
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'gender' => $request->gender,
            'department' => $request->department,
            'designation' => $request->designation,
            'date_of_joining' =>$request->date_of_joining,
            'blood_group' =>$request->blood_group,
            'city'=>$request->city,
            'address'=>$request->address,
            'gender'=>$request->gender,
            'father_name'=>$request->father_name,
            'date_of_birth'=>$request->date_of_birth,
            'marital_status'=>$request->marital_status,
            'physically_challenged'=>$request->physically_challenged,
            'state'=>$request->state,
            'pin'=>$request->pin,
            'confirmation_date'=>$request->confirmation_date,
            'employee_type'=>$request->employee_type,
            'probation_period_days'=>$request->probation_period_days
        ]);

        return response()->json([
            'message' => 'Employee updated successfully',
            'employee' => $employee
        ]);
    }

}
