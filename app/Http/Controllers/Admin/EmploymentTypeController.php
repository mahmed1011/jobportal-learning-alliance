<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EmploymentType;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class EmploymentTypeController extends Controller
{
    // Show all employment types (admin panel)
    public function index()
    {
        try {
            $employmentTypes = EmploymentType::all();
            return view('admin.EmploymentType.show-employmentType', compact('employmentTypes'));
        } catch (\Exception $e) {
            Log::error('EmploymentType Index Error: '.$e->getMessage());
            return back()->with('error', 'Unable to fetch employment types.');
        }
    }

    // Store new employment type
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            EmploymentType::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ]);

            return redirect()->route('employment-types.index')
                ->with('success', 'Employment type created successfully.');
        } catch (\Exception $e) {
            Log::error('EmploymentType Store Error: '.$e->getMessage());
            return back()->withInput()->with('error', 'Failed to create employment type.');
        }
    }

    // Update employment type
    public function update(Request $request, EmploymentType $employmentType)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $employmentType->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ]);

            return redirect()->route('employment-types.index')
                ->with('success', 'Employment type updated successfully.');
        } catch (\Exception $e) {
            Log::error('EmploymentType Update Error: '.$e->getMessage());
            return back()->withInput()->with('error', 'Failed to update employment type.');
        }
    }

    // Delete employment type
    public function destroy(EmploymentType $employmentType)
    {
        try {
            $employmentType->delete();
            return redirect()->route('employment-types.index')
                ->with('success', 'Employment type deleted successfully.');
        } catch (\Exception $e) {
            Log::error('EmploymentType Delete Error: '.$e->getMessage());
            return back()->with('error', 'Failed to delete employment type.');
        }
    }
}
