<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }

public function newJoineesThisWeek()
{
    $startOfWeek = Carbon::now()->startOfWeek();
    $endOfWeek = Carbon::now()->endOfWeek();

    $joinees = Employee::whereBetween('date_of_joining', [$startOfWeek, $endOfWeek])->get();

    return response()->json([
        'count' => $joinees->count(),
        'employees' => $joinees
    ]);
}

    public function filterEmployee(Request $request)
    {
        $query = Employee::with('leaveBalance'); 

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('department', 'like', "%{$search}%")
              ->orWhere('designation', 'like', "%{$search}%");
            });
        }

        $employees = $query->paginate(3);

        return response()->json([
            'data' => $employees->items(),
            'current_page' => $employees->currentPage(),
            'last_page' => $employees->lastPage(),
            'per_page' => $employees->perPage(),
            'total' => $employees->total()
        ]);
    }

    public function birthdayEmployees()
    {
        $today = Carbon::now()->format('m-d');

        $employees = Employee::whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') = ?", [$today])->get();

        return response()->json($employees);
    }
    public function getLeaveBalance($employeeId)
    {
        $employee = Employee::with('leaveBalance')->find($employeeId);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        return response()->json($employee);
    }

    public function totalEmployees()
    {
        $count = Employee::count();
        return response()->json([
            'total_employees' => $count
        ]);
    }
    // public function getNewJoineesThisMonth(){
    //     $newJoinees = Employee::whereMonth('date_of_joining', now()->month)
    //         ->whereYear('date_of_joining', now()->year)
    //         ->count();            
    //     return response()->json([
    //         'count' => $newJoinees->count(),
    //         'new_joinees' => $newJoinees
    //     ]);
    // }
    public function getNewJoineesToday(){
        $newJoinees = Employee::whereMonth('date_of_joining', now())
            ->whereDate('date_of_joining', now()->toDateString());         
        return response()->json([
            'new_joinees' => $newJoinees,
             'count'=>$newJoinees->count()
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
    public function destroy($id)
    {
        $employee = Employee::where('employee_id', $id)->first();

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully']);
    }

}
