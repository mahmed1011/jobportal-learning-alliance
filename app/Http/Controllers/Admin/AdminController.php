<?php

namespace App\Http\Controllers\Admin;

use App\Models\Visitor;
use Illuminate\Http\Request;;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function index()
    {
        // Visitors
        $todayVisitors      = Visitor::whereDate('visit_date', today())->count();
        $yesterdayVisitors  = Visitor::whereDate('visit_date', today()->subDay())->count();
        $allVisitors        = Visitor::count();
        $newVisitors        = Visitor::select('ip_address')->distinct()->count();

        // Growth calculations
        $todayGrowth = $yesterdayVisitors > 0
            ? round((($todayVisitors - $yesterdayVisitors) / $yesterdayVisitors) * 100, 2)
            : ($todayVisitors > 0 ? 100 : 0);

        $previousWeekVisitors = Visitor::whereBetween('visit_date', [
            now()->subWeek()->startOfWeek(),
            now()->subWeek()->endOfWeek()
        ])->count();

        $thisWeekVisitors = Visitor::whereBetween('visit_date', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();

        $weekGrowth = $previousWeekVisitors > 0
            ? round((($thisWeekVisitors - $previousWeekVisitors) / $previousWeekVisitors) * 100, 2)
            : ($thisWeekVisitors > 0 ? 100 : 0);

        return view('admin.index', compact(
            'todayVisitors',
            'yesterdayVisitors',
            'allVisitors',
            'newVisitors',
            'todayGrowth',
            'previousWeekVisitors',
            'thisWeekVisitors',
            'weekGrowth'
        ));
    }




    public function LoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Welcome to Dashboard!');
        }

        return back()->with('error', 'Invalid email or password.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        return response()->json([
            ['label' => 'Test Search', 'type' => 'Debug', 'url' => '/']
        ]);
    }
}
