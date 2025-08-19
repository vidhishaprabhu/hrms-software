<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function totalLeavesByEmployee(Request $request)
    {
        $count=Leave::count();
        return response()->json([
            'total_leaves' => $count
        ]);

    }
    public function approvedLeavedCount(Request $request){
        $count=Leave:: where('status','approved')->count();
        return response()->json([
            'approved_leaves' => $count
        ]);
    }
    public function rejectedLeavedCount(Request $request){
        $count=Leave:: where('status','rejected')->count();
        return response()->json([
            'rejected_leaves' => $count
        ]);
    }
    // public function apply(Request $request)
    // {
    //     $request->validate([
    //         'start_date' => 'required|date',
    //         'end_date'   => 'required|date|after_or_equal:start_date',
    //         'reason'     => 'required|string',
    //         'leave_type' => 'required|string',
    //     ]);

    //     $leave = Leave::create([
    //         'user_id'    => Auth::id(),
    //         'start_date' => $request->start_date,
    //         'end_date'   => $request->end_date,
    //         'reason'     => $request->reason,
    //         'leave_type' => $request->leave_type,
    //         'status'     => 'Pending', // default
    //     ]);

    //     return response()->json([
    //         'message' => 'Leave applied successfully!',
    //         'data'    => $leave
    //     ], 201);
    // }
    public function apply(Request $request)
{
    $request->validate([
        'start_date' => 'required|date',
        'end_date'   => 'required|date|after_or_equal:start_date',
        'reason'     => 'required|string',
        'leave_type' => 'required|in:annual,bereavement,restricted_holiday,work_from_home',
    ]);

    $userId = Auth::id();

    // 🔹 Get employee_id from employees table
    $employeeId = \App\Models\Employee::where('user_id', $userId)->value('id'); 
    // or 'employee_id' column if that's what you store

    if (!$employeeId) {
        return response()->json(['message' => 'Employee ID not found for user'], 404);
    }

    // Calculate number of days
    $start = \Carbon\Carbon::parse($request->start_date);
    $end   = \Carbon\Carbon::parse($request->end_date);
    $days  = $start->diffInDays($end) + 1;

    // Get leave balance by employee_id
    $leaveBalance = \App\Models\LeaveBalance::where('employee_id', $employeeId)->first();

    if (!$leaveBalance) {
        return response()->json(['message' => 'Leave balance not found'], 404);
    }

    // Map leave type to column in leave_balances table
    $leaveColumns = [
        'annual'         => 'annual_leave',
        'bereavement'    => 'bereavement_leave',
        'restricted'=> 'restricted_holiday', 
        'work_from_home' => 'work_from_home'
    ];

    $column = $leaveColumns[$request->leave_type];

    // Check balance
    if ($leaveBalance->$column < $days) {
        return response()->json(['message' => 'Insufficient leave balance'], 400);
    }

    // Deduct balance
    $leaveBalance->$column -= $days;
    $leaveBalance->save();

    // Save leave record
    $leave = \App\Models\Leave::create([
        'user_id'     => $userId,
        'employee_id' => $employeeId, 
        'start_date'  => $request->start_date,
        'end_date'    => $request->end_date,
        'reason'      => $request->reason,
        'leave_type'  => $request->leave_type,
        'status'      => 'Pending'
    ]);

    return response()->json([
        'message' => 'Leave applied successfully!',
        'data'    => $leave
    ], 201);
}


     
}
