<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    public function index(Request $request) {
        $userId = auth()->id();

        $checkIn = Attendance::where('user_id', $userId)
             ->latest()
             ->value('check_in');


        return response()->json($checkIn);
    }
    public function getWeeklyNewJoins()
    {
        $data = collect(range(0, 6))->map(function ($day) {
        $date = \Carbon\Carbon::now()->subDays($day)->toDateString();

        $count = Employee::whereDate('joining_date', $date)->count();

        return [
            'date' => $date,
            'count' => $count
        ];
        })->reverse()->values();

        return response()->json($data);
    }

    public function getAttendanceReport()
    {
        $totalEmployees = Employee::count(); 

        $data = collect(range(0, 6))->map(function ($day) use ($totalEmployees) {
        $date = Carbon::now()->subDays($day)->toDateString();

        $present = Attendance::whereDate('attendance_date', $date)
                    ->where('status', 'present')   
                    ->distinct('user_id')          
                    ->count('user_id');

        $percentage = $totalEmployees > 0
            ? round(($present / $totalEmployees) * 100, 2)
            : 0;

        return [
            'date' => $date,
            'percentage' => $percentage
        ];
        })->reverse()->values();

        return response()->json($data);
    }
     public function getAttendanceReportMonthly()
    {
        $totalEmployees = Employee::count(); 

        $data = collect(range(0, 29))->map(function ($day) use ($totalEmployees) {
        $date = Carbon::now()->subDays($day)->toDateString();

        $present = Attendance::whereDate('attendance_date', $date)
                    ->where('status', 'present')   
                    ->distinct('user_id')          
                    ->count('user_id');

        $percentage = $totalEmployees > 0
            ? round(($present / $totalEmployees) * 100, 2)
            : 0;

        return [
            'date' => $date,
            'percentage' => $percentage
        ];
        })->reverse()->values();

        return response()->json($data);
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

    
        $checkInTime = Carbon::parse($attendance->check_in);
        $checkOutTime = Carbon::parse($attendance->check_out);

        $durationHours = $checkInTime->diffInHours($checkOutTime);

    
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
        ->whereRaw('TIMESTAMPDIFF(HOUR, check_in, check_out) >= 8')
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

