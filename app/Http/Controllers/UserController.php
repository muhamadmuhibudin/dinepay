<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::whereHas('role', function($query) {
            $query->where('role_name', '!=', 'customer');
        })->orderBy('fullname', 'asc')->get();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::orderBy('role_name', 'asc')->get();
    
        return view('admin.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'phone' => 'required|string|max:20|unique:users,phone',
            'email' => 'required|email|max:255|unique:users,email',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        // Create user
        $validatedData = $validated;
        $validatedData['password'] = bcrypt($validatedData['password']);
        User::create($validatedData);
        
        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::orderBy('role_name', 'asc')->get();
        return view('admin.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'fullname'     => 'required|string|max:255',
            'username'     => 'required|string|max:255|unique:users,username,' . $id,
            'phone'        => 'required|string|max:20|unique:users,phone,' . $id,
            'email'        => 'required|email|max:255|unique:users,email,' . $id,
            'role_id'      => 'required|exists:roles,id',
            
            'old_password' => 'nullable|required_with:password|string',
            
            'password'     => 'nullable|string|min:8|confirmed|different:old_password', 
        ]);
        
        if ($request->filled('password')) {
            if (!\Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'Current password does not match our records.'])->withInput();
            }
            
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        unset($validated['old_password']);

        $user->update($validated);
        
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
