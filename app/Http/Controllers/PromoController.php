<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;
use App\Models\Outlet;

class PromoController extends Controller {
    public function index(Outlet $outlet, Request $request) {
        $search = $request->input('search');
        $promos_paginated = $outlet->promos()
            ->when($search, fn($q) => $q->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('promo_code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            }))
            ->orderBy('start_date', 'desc')
            ->paginate(5)
            ->withQueryString();

        return view('pages.outlet.promo.index', ['outlet' => $outlet, 'promos' => $promos_paginated]);
    }

    public function create(Outlet $outlet) {
        return view('pages.outlet.promo.create', ['outlet' => $outlet]);
    }

    public function store(Outlet $outlet, Request $request) {
        $validated = $request->validate([
            'promo_code' => [
                'required',
                'string',
                'max:20',
                'alpha_num',
                'unique:promos,promo_code,NULL,id,outlet_id,' . $outlet->id
            ],
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:percentage,fixed',
            'value' => [
                'required',
                'numeric',
                'min:0',
                $request->type === 'percentage' ? 'max:100' : 'min:0'
            ],
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
        ]);

        $outlet->promos()->create([
            'promo_code' => $validated['promo_code'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'value' => $validated['value'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_active' => $validated['is_active'],
        ]);

        return to_route('outlet.promo.index', $outlet)->with('success', 'Promo created successfully');
    }

    public function edit(Outlet $outlet, Promo $promo) {
        abort_if($promo->outlet_id !== $outlet->id, 404);
        return view('pages.outlet.promo.edit', ['outlet' => $outlet,'promo' => $promo]);
    }

    public function update(Outlet $outlet, Promo $promo, Request $request) {
        abort_if($promo->outlet_id !== $outlet->id, 404);
        $validated = $request->validate([
            'promo_code' => [
                'required',
                'string',
                'max:20',
                'alpha_num',
                'unique:promos,promo_code,NULL,id,outlet_id,' . $outlet->id
            ],
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:percentage,fixed',
            'value' => [
                'required',
                'numeric',
                'min:0',
                $request->type === 'percentage' ? 'max:100' : 'min:0'
            ],
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
        ]);

        $outlet->promos()->create([
            'promo_code' => $validated['promo_code'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'value' => $validated['value'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_active' => $validated['is_active'],
        ]);

        return to_route('outlet.promo.index', $outlet)->with('success', 'Promo updated successfully');
    }

    public function destroy(Outlet $outlet, Promo $promo) {
        abort_if($promo->outlet_id !== $outlet->id, 404);
        $promo->delete();
        return redirect()
            ->route('outlet.promo.index', $outlet)
            ->with('success', 'Promo successfully deleted');
    }
}
