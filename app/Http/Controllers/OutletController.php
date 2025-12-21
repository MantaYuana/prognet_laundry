<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outlet;

class OutletController extends Controller {
    public function index(Request $request) {
        $search = $request->input('search');
        $usersPaginated = Outlet::all();

        return view('outlet.index', [$usersPaginated]);
    }

    public function create() {
        return view('outlet.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|min:5',
        ]);

        Outlet::create([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'phone_number' => $validated['phone_number'],
        ]);

        return to_route('outlet.index')->with('success', 'Outlet created successfully');
    }

    public function edit(Outlet $outlet) {
        $target_outlet = Outlet::find($outlet);
        return view('outlet.edit', compact('outlet'));
    }

    public function update(Request $request, Outlet $outlet) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|min:5',
        ]);

        $outlet->update([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'phone_number' => $validated['phone_number'],
        ]);

        return to_route('outlet.index')->with('success', 'Outlet updated successfully');
    }

    public function destroy(Outlet $outlet) {
        $target_outlet = Outlet::find($outlet);
        $target_outlet->delete();
    }
}
