<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
    $userId = auth()->id(); // or $request->user_id if you're passing it manually

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





}

