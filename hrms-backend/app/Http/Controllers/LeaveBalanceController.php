<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeaveBalanceController extends Controller
{
    public function index(Request $request){
        $user = $request->user();

        // Eager load the employee and leaveBalance relationships
        $user->load('employee.leaveBalance');

        // Check if the user has a linked employee and leave balance
        if (!$user->employee || !$user->employee->leaveBalance) {
            return response()->json(['message' => 'No leave balances found for this user.'], 404);
        }

        // Return the specific leave balance attributes
        return response()->json([
            'bereavement_leave' => $user->employee->leaveBalance->bereavement_leave,
            'annual_leave' => $user->employee->leaveBalance->annual_leave,
            'restricted_holiday' => $user->employee->leaveBalance->restricted_holiday,
            'work_from_home' => $user->employee->leaveBalance->work_from_home,
        ]);
    }

}
