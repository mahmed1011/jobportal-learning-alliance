<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    public function index()
    {
        try {
            $departments = Department::all();
            return view('admin.departments.show-departments', compact('departments'));
        } catch (\Exception $e) {
            Log::error('Department Index Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to fetch departments.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            Department::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ]);

            return redirect()->route('departments.index')
                ->with('success', 'Department created successfully.');
        } catch (\Exception $e) {
            Log::error('Department Store Error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create department.');
        }
    }

    public function update(Request $request, Department $department)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $department->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ]);

            return redirect()->route('departments.index')
                ->with('success', 'Department updated successfully.');
        } catch (\Exception $e) {
            Log::error('Department Update Error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update department.');
        }
    }

    public function destroy(Department $department)
    {
        try {
            $department->delete();
            return redirect()->route('departments.index')
                ->with('success', 'Department deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Department Delete Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete department.');
        }
    }
}
