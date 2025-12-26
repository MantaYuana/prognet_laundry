<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaundryService;
use App\Models\Outlet;

class LaundryServiceController extends Controller {
    public function index(Outlet $outlet, Request $request) {
        $search = $request->input('search');
        $laundry_service_paginated = $outlet->services()
        ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%"))
        ->orderBy('name')
        ->paginate(5)
        ->withQueryString();

        // $laundry_service_paginated = $outlet->services()->latest()->get();
        return view('pages.outlet.services.index', compact('outlet', 'laundry_service_paginated'));
    }

    public function create(Outlet $outlet, LaundryService $laundry_service) {
        abort_unless($laundry_service->outlet_id === $outlet->id, 404);
        return view('pages.outlet.services.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'service_type' => 'required|string|max:255',
            'price' => 'required|string|min:5',
        ]);

        LaundryService::create([
            'name' => $validated['name'],
            'service_type' => $validated['service_type'],
            'price' => $validated['price'],
        ]);

        return to_route('outlet.services.index')->with('success', 'Laundry Service created successfully');
    }

    public function edit(Outlet $outlet, LaundryService $laundry_service) {
        abort_unless($laundry_service->outlet_id === $outlet->id, 404);
        $target_laundry_service = LaundryService::find($laundry_service);
        
        return view('page.outlet.services.edit', $target_laundry_service);
    }

    public function update(Request $request, LaundryService $laundry_service) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'service_type' => 'required|string|max:255',
            'price' => 'required|string|min:5',
        ]);

        $laundry_service->update([
            'name' => $validated['name'],
            'service_type' => $validated['service_type'],
            'price' => $validated['price'],
        ]);

        return to_route('outlet.services.index')->with('success', 'Laundry Service updated successfully');
    }

    public function destroy(LaundryService $laundry_service) {
        $target_laundry_service = LaundryService::find($laundry_service);
        $target_laundry_service->delete();
    }
}
