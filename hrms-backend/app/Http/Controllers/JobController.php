<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
    public function download($id)
    {
        $job = Job::with('user')->findOrFail($id);
        $pdf = Pdf::loadView('pdf.job', compact('job')); 
        return $pdf->download("job_description_{$job->id}.pdf");
    }
    public function show($id)
    {
        return Job::findOrFail($id);
    }
    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);
        $job->update($request->all());

        return response()->json(['message' => 'Job Description updated successfully']);
    }
    

}
