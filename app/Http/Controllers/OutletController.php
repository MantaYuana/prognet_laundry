<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OutletController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $user = User::find(Auth::id());
        $outletPaginated = $user->outlets;

        // return view('pages.outlet.index', [$usersPaginated]);
        return view('pages.outlet.index', compact('outletPaginated'));
    }

    public function create()
    {
        return view('pages.outlet.create');
    }

    public function store(Request $request)
    {
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

        return to_route('pages.outlet.index')->with('success', 'Outlet created successfully');
    }

    public function edit(Outlet $outlet)
    {
        $target_outlet = Outlet::find($outlet);
        return view('pages.outlet.edit', compact('outlet'));
    }

    public function update(Request $request, Outlet $outlet)
    {
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

        return to_route('pages.outlet.index')->with('success', 'Outlet updated successfully');
    }

    public function destroy(Outlet $outlet)
    {
        $target_outlet = Outlet::find($outlet);
        $target_outlet->delete();
    }
}
