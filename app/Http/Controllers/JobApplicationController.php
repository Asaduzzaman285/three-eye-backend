<?php

namespace App\Http\Controllers;

use App\Models\Portfolio\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class JobApplicationController extends Controller
{
    /**
     * Store a newly created job application.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'parents_name' => 'nullable|string|max:255',
            'present_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'education' => 'nullable|array',
            'experience' => 'nullable|string',
            'position' => 'nullable|string|max:255',
            'current_salary' => 'nullable|numeric',
            'expected_salary' => 'nullable|numeric',
            'social_links' => 'nullable|array',
            'image_path' => 'nullable|string',
            'resume_path' => 'nullable|string',
            'job_id' => 'nullable|exists:jobs,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $application = JobApplication::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Application submitted successfully',
                'data' => $application
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to submit application',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin: List all applications.
     */
    public function index()
    {
        try {
            $applications = JobApplication::with('job')->orderBy('created_at', 'desc')->get();
            return response()->json([
                'status' => 'success',
                'data' => $applications
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch applications'
            ], 500);
        }
    }

    /**
     * Admin: Update application status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,shortlisted,rejected'
        ]);

        try {
            $application = JobApplication::findOrFail($id);
            $application->status = $request->status;
            $application->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Status updated successfully',
                'data' => $application
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update status'
            ], 500);
        }
    }

    /**
     * Admin: Delete application.
     */
    public function destroy($id)
    {
        try {
            $application = JobApplication::findOrFail($id);
            $application->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Application deleted'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete application'
            ], 500);
        }
    }
}
