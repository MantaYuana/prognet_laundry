<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Outlet;

class CustomerOutletFinderController extends Controller {
    public function index(Request $request) {
        $search = $request->input('search');

        // TODO: also load owner profile mate
        $outlets = Outlet::when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhere('phone_number', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(9)
            ->withQueryString();

        return view('pages.customer.outlet.index', compact('outlets'));
    }

    public function show(Outlet $outlet) {
        // TODO: also load owner profile mate
        $outlet->load(['services']);

        return view('pages.customer.outlet.show', compact('outlet'));
    }
}
