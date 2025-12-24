<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Outlet;

class StaffManagementController extends Controller {
    public function index(Outlet $outlet, Request $request) {
        $search = $request->input('search');
        $staff_paginated = $outlet->staff()->latest()->get();

        return view('pages.admin.staff.index', compact($staff_paginated));
    }

    public function create() {
        $outlets = Outlet::orderBy('name')->pluck('name', 'id');
        return view('pages.admin.staff.create', compact('outlets'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:13',
            'outlet_id' => 'required|exists:outlets,id',
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|in:staff,owner,customer',
        ]);

        Staff::create([
            'name' => $validated['name'],
            'title' => $validated['title'],
            'address' => $validated['address'],
            'phone_number' => $validated['phone_number'],
            'outlet_id' => $validated['outlet_id'],
            'user_id' => $validated['user_id'],
        ])->assignRole($validated['role']);

        return to_route('pages.admin.staff.index')->with('success', 'Staff created successfully');
    }

    public function edit(Staff $staff) {
        $target_staff = Staff::find($staff);
        $outlets = Outlet::orderBy('name')->pluck('name', 'id');
        return view('admin.staff.edit', compact('target_staff', 'outlets'));
    }

    public function update(Request $request, Staff $staff) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:13',
            'outlet_id' => 'required|exists:outlets,id',
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|in:staff,owner,customer',
        ]);

        $staff->update([
            'name' => $validated['name'],
            'title' => $validated['title'],
            'address' => $validated['address'],
            'phone_number' => $validated['phone_number'],
            'outlet_id' => $validated['outlet_id'],
            'user_id' => $validated['user_id'],
        ]);
        $staff->revokePermissionTo($validated['role']);

        return to_route('pages.admin.staff.index')->with('success', 'Staff updated successfully');
    }

    public function destroy(Staff $staff) {
        $target_staff = Staff::find($staff);
        $target_staff->delete();

        return redirect()->route('pages.admin.staff.index')->with('success', 'Staff deleted successfully');
    }
}
