<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\LaundryService;
use Illuminate\Support\Str;
use App\Services\OrderService;

class StaffOrderController extends Controller {
    public function index() {
        $orders = Order::with(['customer', 'items.laundryService'])
            ->latest()
            ->paginate(10);

        return view('pages.outlet.order.staff.index', compact('orders'));
    }

    public function show(Order $order) {
        $order->load(['customer', 'items.laundryService']);
        return view('pages.outlet.order.staff.show', compact('order'));
    }


    public function create() {
        return view('pages.outlet.order.staff.create');
    }

    public function store(Request $request, OrderService $orderService) {
        $data = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'outlet_id' => 'required|exists:outlets,id',
            'address' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.laundry_service_id' => 'required|exists:laundry_services,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $orderService->create($data, $request->user()->id ?? null);

        return redirect()
            ->route('outlet.staff.order.index')
            ->with('success', 'Order created');
    }

    public function updateStatus(Request $request, Order $order, string $status) {
        $validStatuses = ['ordered', 'accepted', 'being_washed', 'ready_for_pickup', 'done'];
        abort_unless(in_array($status, $validStatuses, true), 422, 'Invalid status');

        $order->update(['status' => $status]);

        return redirect()->route('outlet.staff.order.show', $order)->with('success', 'Status updated');
    }
}
