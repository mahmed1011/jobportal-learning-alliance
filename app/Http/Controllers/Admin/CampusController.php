<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Campus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CampusController extends Controller
{
    // Show all campuses
    public function index()
    {
        try {
            $campuses = Campus::all();
            $cities = City::all();
            return view('admin.Campuses.show-campuses', compact('campuses','cities'));
        } catch (\Exception $e) {
            Log::error('Campus Index Error: '.$e->getMessage());
            return back()->with('error', 'Unable to fetch campuses.');
        }
    }

    // Store new campus
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('campuses', 'public');
            }

            Campus::create([
                'name' => $request->name,
                'city' => $request->city,
                'address' => $request->address,
                'logo_path' => $logoPath,
            ]);

            return redirect()->route('campuses.index')
                ->with('success', 'Campus created successfully.');
        } catch (\Exception $e) {
            Log::error('Campus Store Error: '.$e->getMessage());
            return back()->withInput()->with('error', 'Failed to create campus.');
        }
    }

    // Update campus
    public function update(Request $request, Campus $campus)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $logoPath = $campus->logo_path;
            if ($request->hasFile('logo')) {
                // delete old logo
                if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                    Storage::disk('public')->delete($logoPath);
                }
                $logoPath = $request->file('logo')->store('campuses', 'public');
            }

            $campus->update([
                'name' => $request->name,
                'city' => $request->city,
                'address' => $request->address,
                'logo_path' => $logoPath,
            ]);

            return redirect()->route('campuses.index')
                ->with('success', 'Campus updated successfully.');
        } catch (\Exception $e) {
            Log::error('Campus Update Error: '.$e->getMessage());
            return back()->withInput()->with('error', 'Failed to update campus.');
        }
    }

    // Delete campus
    public function destroy(Campus $campus)
    {
        try {
            if ($campus->logo_path && Storage::disk('public')->exists($campus->logo_path)) {
                Storage::disk('public')->delete($campus->logo_path);
            }
            $campus->delete();
            return redirect()->route('campuses.index')
                ->with('success', 'Campus deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Campus Delete Error: '.$e->getMessage());
            return back()->with('error', 'Failed to delete campus.');
        }
    }
}
