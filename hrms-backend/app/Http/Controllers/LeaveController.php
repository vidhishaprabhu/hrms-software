<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;

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
}
