<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    public function index(Request $request) {
    $userId = auth()->id(); // get authenticated user ID

    $checkIn = Attendance::where('user_id', $userId)
             ->latest()
             ->value('check_in');


    return response()->json($checkIn);
    }


    public function destroy($id){
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();
        return response()->json(['message' => 'Attendance record deleted successfully']);
    }
public function store(Request $request)
{

   $userId = auth()->id(); // logged-in user ID
    $today = now()->toDateString(); // 'YYYY-MM-DD'

    // Check if already checked in today
    // $alreadyCheckedIn = Attendance::where('user_id', $userId)
    //     ->whereDate('attendance_date', $today)
    //     ->exists();

    // if ($alreadyCheckedIn) {
    //     return response()->json([
    //         'message' => 'You have already checked in today.',
    //     ], 400);
    // }
    
    // Store new attendance record
    $attendance = new Attendance();
    $attendance->user_id = $userId;
    $attendance->check_in = now();
    $attendance->attendance_date = $today; // store only date
    $attendance->save();
    return response()->json([
        'message' => 'Check-in successful',
        'check_in_time' => $attendance->check_in->toDateTimeString(),
    ]);
}
public function signOutByUserId($userId)
{
    $attendance = Attendance::where('user_id', $userId)
        ->whereNull('check_out')
        ->latest('check_in')
        ->first();

    if (!$attendance) {
        return response()->json(['message' => 'No active sign-in found'], 404);
    }

    $attendance->check_out = now();

    // Ensure Carbon instances
    $checkInTime = Carbon::parse($attendance->check_in);
    $checkOutTime = Carbon::parse($attendance->check_out);

    // Calculate duration
    $durationHours = $checkInTime->diffInHours($checkOutTime);

    // Mark status
    $attendance->status = $durationHours >= 8 ? 'Present' : 'Absent';
    $attendance->save();

    return response()->json([
        'message' => 'Sign out successful',
        'attendance_id' => $attendance->id,
        'check_in_time' => $checkInTime->toDateTimeString(),
        'check_out_time' => $checkOutTime->toDateTimeString(),
        'total_working_time' => sprintf('%02d', $durationHours),
        'status' => $attendance->status
    ]);
}
public function getUserAttendanceSummary($userId)
{
    $presentDays = Attendance::where('user_id', $userId)
        ->where('status', 'Present')
        ->whereRaw('TIMESTAMPDIFF(HOUR, check_in, check_out) >= 1')
        ->count();

    $absentDays = Attendance::where('user_id', $userId)
        ->where('status', 'Absent')
        ->count();

    return response()->json([
        'presentDays' => $presentDays,
        'absentDays' => $absentDays
    ]);
}














}

