<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Outlet;
use App\Models\User;
use App\Models\Owner;

class OutletController extends Controller {
    public function index(Request $request) {
        $owner = Owner::where('user_id', Auth::id())->firstOrFail();
        $search = $request->string('search');

        $outletPaginated = $owner->outlets()
            ->when($search, fn($q) => $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%");
            }))
            ->orderBy('name')
            ->paginate(5)
            ->withQueryString();

        return view('pages.outlet.index', compact('outletPaginated'));
    }

    public function show(Outlet $outlet) {
        return view('pages.outlet.show', compact('outlet'));
    }

    public function create() {
        return view('pages.outlet.create');
    }

    public function store(Request $request) {
        $owner = Owner::where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|min:5|max:13',
        ]);

        $owner->outlets()->create([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'phone_number' => $validated['phone_number'],
        ]);

        return to_route('outlet.index')->with('success', 'Outlet created successfully');
    }

    public function edit(Outlet $outlet) {
        return view('pages.outlet.edit', compact('outlet'));
    }

    public function update(Request $request, Outlet $outlet) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|min:5|max:13',
        ]);

        $outlet->update([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'phone_number' => $validated['phone_number'],
        ]);

        return to_route('outlet.index')->with('success', 'Outlet updated successfully');
    }

    public function destroy(Outlet $outlet) {
        $outlet->delete();

        return redirect()
            ->route('outlet.index')
            ->with('success', 'Outlet berhasil dihapus');
    }
}
