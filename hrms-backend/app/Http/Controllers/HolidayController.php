<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function upcomingHolidays(){
        $holidays = Holiday::where('holiday_date', '>=', now()->toDateString())
            ->orderBy('holiday_date', 'asc')
            ->get();
        
        return response()->json($holidays);
    }
    public function updateHoliday(Request $request, $id){
        $holiday = Holiday::findOrFail($id);
        $holiday->update($request->all());

        return response()->json([
            'message' => 'Holiday updated successfully',
            'holiday' => $holiday
        ]);
    }
    public function destroy($id){
        $holiday = Holiday::findOrFail($id);
        $holiday->delete();
        return response()->json(['message' => 'Holiday record deleted successfully']);
    }
    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'holiday_date' => 'required|date',
            'description' => 'nullable|string',
            'type' => 'required|in:Public,Restricted'
        ]);
        $holiday = Holiday::create($request->all());

        return response()->json([
            'message' => 'Holiday created successfully',
            'holiday' => $holiday
        ]);
    }
}
