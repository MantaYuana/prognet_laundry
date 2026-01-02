<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Outlet;
use App\Models\Owner;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

// NOTE: yeah so there was once a concept where theres gonna be cashier etc etc, now lets just try to implement a staff first
class StaffManagementController extends Controller {
    public function index(Outlet $outlet, Request $request) {
        $owner = Owner::where('user_id', Auth::id())->firstOrFail();
        $search = $request->input('search');

        $staff_paginated = Staff::whereHas('outlet', fn($q) => $q->where('owner_id', $owner->id))
            ->when($search, fn($q) => $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%");
            }))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        // return view('pages.outlet.staff.index', compact($staff_paginated));
        return view('pages.outlet.staff.index', [
            'staffPaginated' => $staff_paginated,
        ]);
    }

    public function create() {
        $owner = Owner::where('user_id', Auth::id())->firstOrFail();
        $outlets = $owner->outlets()->orderBy('name')->get();
        return view('pages.outlet.staff.create', compact('outlets'));
    }

    public function store(Request $request) {
        $owner = Owner::where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:13',
            'outlet_id' => [
                'required',
                Rule::exists('outlets', 'id')->where(fn($q) => $q->where('owner_id', $owner->id)),
            ],
            'user_id' => 'required|exists:users,id',
        ]);

        Staff::create([
            'title' => $validated['title'],
            'address' => $validated['address'],
            'phone_number' => $validated['phone_number'],
            'outlet_id' => $validated['outlet_id'],
            'user_id' => $validated['user_id'],
        ])->assignRole('staff');

        return to_route('pages.outlet.staff.index')->with('success', 'Staff created successfully');
    }

    public function edit(Staff $staff) {
        $owner = Owner::where('user_id', Auth::id())->firstOrFail();
        $outlets = $owner->outlets()->orderBy('name')->get();

        // $target_staff = Staff::find($staff);
        // $outlets = Outlet::orderBy('name')->pluck('name', 'id');
        return view('outlet.staff.edit', compact('staff', 'outlets'));
    }

    public function update(Request $request, Staff $staff) {
        $owner = Owner::where('user_id', Auth::id())->firstOrFail();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:13',
            'outlet_id' => [
                'required',
                Rule::exists('outlets', 'id')->where(fn($q) => $q->where('owner_id', $owner->id)),
            ],
            'user_id' => 'required|exists:users,id',
        ]);

        $staff->update([
            'title' => $validated['title'],
            'address' => $validated['address'],
            'phone_number' => $validated['phone_number'],
            'outlet_id' => $validated['outlet_id'],
            'user_id' => $validated['user_id'],
        ]);
        // $staff->revokePermissionTo($validated['role']);

        return to_route('pages.outlet.staff.index')->with('success', 'Staff updated successfully');
    }

    public function destroy(Staff $staff) {
        $owner = Owner::where('user_id', Auth::id())->firstOrFail();
        $staff->delete();

        return redirect()->route('outlet.staff.index')->with('success', 'Staff deleted successfully');
    }
}
