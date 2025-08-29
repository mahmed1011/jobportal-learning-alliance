<?php

namespace App\Http\Controllers\Admin;

use App\Models\Job;
use App\Models\Campus;
use App\Models\Location;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EmploymentType;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class JobController extends Controller
{
    // Show all jobs
    public function index()
    {
        try {
            $user = auth()->user();

            // user ke campuses decode karo
            $userCampusIds = json_decode($user->campus_id, true) ?? [];

            // agar admin hai to sab jobs dikhao
            if ($user->hasRole('Admin')) {
                $jobs = Job::with(['department', 'employmentType', 'location', 'campus'])->get();
            } else {
                // otherwise sirf unhi campuses ki jobs
                $jobs = Job::with(['department', 'employmentType', 'location', 'campus'])
                    ->whereIn('campus_id', $userCampusIds)
                    ->get();
            }

            $departments = Department::all();
            $employmentTypes = EmploymentType::all();
            $locations = Location::all();
            $campuses = Campus::all();

            return view('admin.Jobs.show-jobs', compact('jobs', 'departments', 'employmentTypes', 'locations', 'campuses'));
        } catch (\Exception $e) {
            Log::error('Job Index Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to fetch jobs.');
        }
    }

    // Store new job
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'department_id' => 'required|exists:departments,id',
                'employment_type_id' => 'required|exists:employment_types,id',
                'campus_ids' => 'nullable|array', // ✅ must be array
                'campus_ids.*' => 'exists:campuses,id', // validate each campus
                'description' => 'required|string',
                'status' => 'required|in:draft,published,closed',
            ]);

            Job::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'department_id' => $request->department_id,
                'employment_type_id' => $request->employment_type_id,
                'campus_ids' => $request->campus_ids ? json_encode($request->campus_ids) : null, // ✅ fixed
                'description' => $request->description,
                'status' => $request->status,
                'posted_at' => now(),
                'expires_at' => $request->expires_at,
                'created_by' => auth()->id(),
            ]);

            return redirect()->route('jobs.index')
                ->with('success', 'Job created successfully.');
        } catch (\Exception $e) {
            Log::error('Job Store Error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create job.');
        }
    }


    // Update job
    // Update job
    public function update(Request $request, Job $job)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'department_id' => 'required|exists:departments,id',
                'employment_type_id' => 'required|exists:employment_types,id',
                'campus_ids' => 'nullable|array', // ✅ fixed
                'campus_ids.*' => 'exists:campuses,id', // validate each campus id
                'description' => 'required|string',
                'status' => 'required|in:draft,published,closed',
            ]);

            $job->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'department_id' => $request->department_id,
                'employment_type_id' => $request->employment_type_id,
                'campus_ids' => $request->campus_ids ? json_encode($request->campus_ids) : null, // ✅ fixed
                'description' => $request->description,
                'status' => $request->status,
                'expires_at' => $request->expires_at,
            ]);

            return redirect()->route('jobs.index')
                ->with('success', 'Job updated successfully.');
        } catch (\Exception $e) {
            Log::error('Job Update Error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update job.');
        }
    }


    // Delete job
    public function destroy(Job $job)
    {
        try {
            $job->delete();
            return redirect()->route('jobs.index')
                ->with('success', 'Job deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Job Delete Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete job.');
        }
    }
}
