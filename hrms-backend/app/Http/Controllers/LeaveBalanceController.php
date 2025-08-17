<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveBalance;
use Illuminate\Http\Request;

class LeaveBalanceController extends Controller
{
   public function index()
{
     $userId = auth()->id();

    $employee = Employee::where('user_id', $userId)->first();

    if (!$employee) {
        return response()->json([
            'message' => 'Employee record not found for this user.'
        ], 404);
    }
    $leaveBalance = LeaveBalance::where('employee_id', $employee->id)->first();

    if (!$leaveBalance) {
        return response()->json([
            'message' => 'No leave balance found for this employee.'
        ], 404);
    }

    return response()->json([
        'employee_id'   => $employee->id,
        'leave_balance' => $leaveBalance
    ]);
}



    public function store(Request $request)
    {
        $validated = $request->validate([
        'employee_id' => 'required|string|exists:employees,employee_id',
        'bereavement_leave' => 'required|integer|min:0',
        'annual_leave' => 'required|integer|min:0',
        'restricted_holiday' => 'required|integer|min:0',
        'work_from_home' => 'required|integer|min:0',
        ]);

        $employee = Employee::where('employee_id', $validated['employee_id'])->first();

        $leave = LeaveBalance::updateOrCreate(
        ['employee_id' => $employee->id],
        [
            'bereavement_leave' => $validated['bereavement_leave'],
            'annual_leave' => $validated['annual_leave'],
            'restricted_holiday' => $validated['restricted_holiday'],
            'work_from_home' => $validated['work_from_home'],
        ]
        );

        return response()->json([
        'message' => 'Leave allocation saved successfully',
        'data' => $leave
        ]);
    }

}
