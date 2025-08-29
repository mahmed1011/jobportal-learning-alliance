<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    // Show all locations (admin panel)
    public function index()
    {
        try {
            $locations = Location::all();
            $cities = City::all();
            return view('admin.Locations.show-locations', compact('locations', 'cities'));
        } catch (\Exception $e) {
            Log::error('Location Index Error: '.$e->getMessage());
            return back()->with('error', 'Unable to fetch locations.');
        }
    }

    // Store new location
    public function store(Request $request)
    {
        try {
            $request->validate([
                'city' => 'required|string|max:255',
                'area' => 'nullable|string|max:255',
            ]);

            Location::create([
                'city' => $request->city,
                'area' => $request->area,
            ]);

            return redirect()->route('locations.index')
                ->with('success', 'Location created successfully.');
        } catch (\Exception $e) {
            Log::error('Location Store Error: '.$e->getMessage());
            return back()->withInput()->with('error', 'Failed to create location.');
        }
    }

    // Update location
    public function update(Request $request, Location $location)
    {
        try {
            $request->validate([
                'city' => 'required|string|max:255',
                'area' => 'nullable|string|max:255',
            ]);

            $location->update([
                'city' => $request->city,
                'area' => $request->area,
            ]);

            return redirect()->route('locations.index')
                ->with('success', 'Location updated successfully.');
        } catch (\Exception $e) {
            Log::error('Location Update Error: '.$e->getMessage());
            return back()->withInput()->with('error', 'Failed to update location.');
        }
    }

    // Delete location
    public function destroy(Location $location)
    {
        try {
            $location->delete();
            return redirect()->route('locations.index')
                ->with('success', 'Location deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Location Delete Error: '.$e->getMessage());
            return back()->with('error', 'Failed to delete location.');
        }
    }
}
