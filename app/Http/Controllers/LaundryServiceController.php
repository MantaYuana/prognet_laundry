<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaundryService;
use App\Models\Outlet;

class LaundryServiceController extends Controller {
    public function index(Outlet $outlet, Request $request) {
        $search = $request->input('search');
        $laundry_service_paginated = $outlet->services()
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('name')
            ->paginate(5)
            ->withQueryString();

        return view('pages.outlet.services.index', compact('outlet', 'laundry_service_paginated'));
    }

    public function create(Outlet $outlet, LaundryService $service) {
        return view('pages.outlet.services.create', compact('outlet'));
    }

    public function store(Outlet $outlet, Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'service_type' => 'required|string|max:255',
            'price' => 'required|string|min:5',
        ]);

        $outlet->services()->create([
            'name' => $validated['name'],
            'service_type' => $validated['service_type'],
            'price' => $validated['price'],
        ]);

        return to_route('outlet.services.index', $outlet)->with('success', 'Laundry Service created successfully');
    }

    public function edit(Outlet $outlet, LaundryService $service) {
        return view('pages.outlet.services.edit', compact('outlet', 'service'));
    }

    public function update(Outlet $outlet, Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'service_type' => 'required|string|max:255',
            'price' => 'required|string|min:5',
        ]);

        $outlet->services()->update([
            'name' => $validated['name'],
            'service_type' => $validated['service_type'],
            'price' => $validated['price'],
        ]);

        return to_route('outlet.services.index', $outlet)->with('success', 'Laundry Service updated successfully');
    }

    public function destroy(Outlet $outlet, LaundryService $service) {
        $service->delete();
        return redirect()
            ->route('outlet.services.index', $outlet)
            ->with('success', 'Service successfully deleted');
    }
}
