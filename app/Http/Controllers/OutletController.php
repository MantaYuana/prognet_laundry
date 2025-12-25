<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Outlet;
use App\Models\User;


// Auth::loginUsingId(1); // login paksa sebagai user id 1


class OutletController extends Controller
{
    // FIXME: we need to start using this
    // public function index(Request $request)
    // {
    //     $search = $request->input('search');
    //     $user = User::find(Auth::id());
    //     $outletPaginated = $user->outlets;

    //     // return view('pages.outlet.index', [$usersPaginated]);
    //     return view('pages.outlet.index', compact('outletPaginated'));
    // }


    public function index(Request $request)
    {

        $search = $request->query('search');

        $rows = Outlet::where('user_id', Auth::id())
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhere('phone_number', 'like', "%{$search}%");
                });
            })
            ->paginate(5);

        return view('pages.outlet.index', compact('rows'));
    }

    public function create()
    {
        return view('pages.outlet.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone_number' => 'required|string|max:20',
        ]);

        auth()->user()->outlets()->create($validated);

        return redirect()
            ->route('outlet.index')
            ->with('success', 'Outlet berhasil dibuat');
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'address' => 'required|string|max:255',
    //         'phone_number' => 'required|string|min:5',
    //     ]);

    //     Outlet::create([
    //         'name' => $validated['name'],
    //         'address' => $validated['address'],
    //         'phone_number' => $validated['phone_number'],
    //     ]);

    //     return to_route('pages.outlet.index')->with('success', 'Outlet created successfully');
    // }

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
            'phone_number' => 'required|string|min:5|max:13',
            'user_id' => 'required|exists:users,id',
        ]);

        $outlet->update([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'phone_number' => $validated['phone_number'],
            'user_id' => $validated['user_id'],
        ]);

        return to_route('outlet.index')->with('success', 'Outlet updated successfully');
    }

    // public function destroy(Outlet $outlet)
    // {
    //     $target_outlet = Outlet::find($outlet);
    //     $target_outlet->delete();
    // }

    public function destroy(Outlet $outlet)
    {
        $outlet->delete();

        return redirect()
            ->route('outlet.index')
            ->with('success', 'Outlet berhasil dihapus');
    }

}
