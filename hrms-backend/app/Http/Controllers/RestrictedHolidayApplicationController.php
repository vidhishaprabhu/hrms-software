<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;
use App\Models\RestrictedHolidayApplication;

class RestrictedHolidayApplicationController extends Controller
{
   public function store(Request $request)
{
    $validated = $request->validate([
        'holiday_name' => 'required|string', 
        'reason' => 'nullable|string',
    ]);

    $application = new RestrictedHolidayApplication();
    $application->user_id = auth()->id();
    $application->holiday_name = $validated['holiday_name'];
    $application->reason = $validated['reason'] ?? null;
    $application->status = 'Pending';
    $application->save();

    return response()->json(['message' => 'Holiday application submitted successfully.']);
}




}
