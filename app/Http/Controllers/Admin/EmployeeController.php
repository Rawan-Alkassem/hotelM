<?php

namespace App\Http\Controllers\Admin;

use Illuminate;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{

public function index(){

// $employees
            $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'Customer');
        })->with('roles')->get();

        return view('employeesmanagement.index', compact('users'));

}

public function create()
{
    // جلب كل الأدوار ما عدا "Customer"
    $roles = \Spatie\Permission\Models\Role::where('name', '!=', 'Customer')->pluck('name');

    return view('employeesmanagement.create', compact('roles'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
        'role' => 'required|exists:roles,name',
    ]);

    $user = User::create([
        'full_name' => $validated['full_name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    $user->assignRole($validated['role']);

    return redirect()->route('employeesmanagement.index')->with('success', 'Employee added successfully.');
}


public function destroy(User $user)
{
    if ($user->hasRole('Customer')) {
        return back()->with('error', 'Cannot delete customers from this panel.');
    }

    $user->delete();
    return back()->with('success', 'Employee deleted successfully.');
}

public function editRole(User $user)
{
    if ($user->hasRole('Customer')) {
        return redirect()->route('employeesmanagement.index')->with('error', 'Cannot modify customer roles.');
    }

    $roles = \Spatie\Permission\Models\Role::where('name', '!=', 'Customer')->pluck('name');

    return view('employeesmanagement.edit-role', compact('user', 'roles'));
}

public function updateRole(Request $request, User $user)
{
    $request->validate([
        'role' => 'required|exists:roles,name',
    ]);

    $user->syncRoles([$request->role]);

    return redirect()->route('employeesmanagement.index')->with('success', 'Role updated successfully.');
}


     }
