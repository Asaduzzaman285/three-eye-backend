<?php

namespace App\Http\Controllers;

use App\Models\Portfolio\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::orderBy('created_at', 'desc')->get();
        return response()->json(['success' => true, 'data' => $jobs]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $job = new Job();
        $job->title = $validated['title'];
        $job->description = $validated['description'] ?? null;
        $job->requirements = $validated['requirements'] ?? null;
        $job->is_active = $validated['is_active'] ?? true;
        
        $job->save();

        return response()->json(['success' => true, 'data' => $job, 'message' => 'Job created successfully.']);
    }

    public function show($id)
    {
        $job = Job::findOrFail($id);
        return response()->json(['success' => true, 'data' => $job]);
    }

    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if (isset($validated['title'])) $job->title = $validated['title'];
        if (array_key_exists('description', $validated)) $job->description = $validated['description'];
        if (array_key_exists('requirements', $validated)) $job->requirements = $validated['requirements'];
        if (isset($validated['is_active'])) $job->is_active = $validated['is_active'];

        $job->save();

        return response()->json(['success' => true, 'data' => $job, 'message' => 'Job updated successfully.']);
    }

    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();

        return response()->json(['success' => true, 'message' => 'Job deleted successfully.']);
    }
}
