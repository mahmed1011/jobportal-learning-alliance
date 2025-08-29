<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Campus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all(); // Spatie Role model
        $campuses = Campus::all(); // ✅ add campuses list

        return view('admin.users-managment.show-users', compact('users', 'roles', 'campuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|exists:roles,name',
            'campus_ids' => 'nullable|array', // ✅ allow multiple
            'campus_ids.*' => 'exists:campuses,id',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'campus_id' => $request->campus_ids ? json_encode($request->campus_ids) : null, // ✅ store as JSON
            ]);

            $user->assignRole($request->role);
            DB::commit();

            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Failed to create user.');
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'role' => 'required|exists:roles,name',
            'campus_ids' => 'nullable|array',
            'campus_ids.*' => 'exists:campuses,id',
        ]);

        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            $user->campus_id = $request->campus_ids ? json_encode($request->campus_ids) : null; // ✅ update
            $user->save();

            $user->syncRoles([$request->role]);
            DB::commit();

            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {

            DB::rollback();
            Log::error('User Update Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update user.');
        }
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
