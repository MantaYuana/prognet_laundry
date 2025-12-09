<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use PDO;

class UserManagementController extends Controller {
    public function index(Request $request) {
        $search = $request->input('search');
        $usersPaginated = User::all();

        return view('admin.users.index', [$usersPaginated]);
    }

    public function create() {
        return view('admin.users.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return to_route('admin.users.index')->with('success', 'User created successfully');
    }

    public function edit(User $user) {
        $target_user = User::find($user);
        return view('admin.users.edit', $target_user);
    }

    public function update(Request $request, User $user) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return to_route('admin.users.index')->with('success', 'User created successfully');
    }

    public function destroy(User $user) {
        $target_user = User::find($user);
        $target_user->delete();
    }
}
