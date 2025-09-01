<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(){
        $jobs=Job::with('user')->latest()->get();
        return response()->json($jobs); 
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'department'       => 'required|string|max:255',
            'responsibilities' => 'nullable|string',
            'qualifications'   => 'nullable|string',
            'user_id'          => 'nullable|exists:users,id',
        ]);
        
        $validated['user_id'] = auth()->id(); 
        $job = Job::create($validated);

        return response()->json([
            'message' => 'Job created successfully',
            'job' => $job,
        ], 201);
    }
}
