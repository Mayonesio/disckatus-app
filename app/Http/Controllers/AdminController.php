<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $roleStats = Role::withCount('users')->get();
        $recentUsers = User::latest()->take(5)->get();
        $users = User::with('roles')->paginate(10);
        $allRoles = Role::all();

        return view('admin.dashboard', compact('roleStats', 'recentUsers', 'users', 'allRoles'));
    }

    public function updateUserRoles(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        $user->roles()->sync($request->roles);

        return redirect()->back()->with('success', 'Roles actualizados correctamente');
    }
}