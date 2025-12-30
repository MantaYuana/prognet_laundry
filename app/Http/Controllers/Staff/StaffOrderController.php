<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\LaundryService;
use Illuminate\Support\Str;

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

    public function store(Request $request) {
        $data = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'outlet_id' => 'required|exists:outlets,id',
            'address' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.laundry_service_id' => 'required|exists:laundry_services,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'code' => 'ORD-' . Str::upper(Str::random(8)),
            'status' => 'ordered',
            'payment_confirm' => false,
            'address' => $data['address'] ?? '',
            'customer_id' => $data['customer_id'] ?? null,
            'outlet_id' => $data['outlet_id'],
            'staff_id' => $request->user()->id ?? null,
            'total' => 0,
        ]);

        $total = 0;
        foreach ($data['items'] as $item) {
            $service = LaundryService::findOrFail($item['laundry_service_id']);
            $unit = $service->price;
            $qty = $item['quantity'];
            $subtotal = $unit * $qty;

            OrderDetail::create([
                'order_id' => $order->id,
                'laundry_service_id' => $service->id,
                'quantity' => $qty,
                'unit_price' => $unit,
                'subtotal' => $subtotal,
            ]);

            $total += $subtotal;
            $order->update(['total' => $total]);

            return $order->load('items.laundryService');
        };

        return redirect()
            ->route('outlet.staff.order.index', $order)
            ->with('success', 'Order created');
    }

    public function updateStatus(Request $request, Order $order, string $status) {
        $validStatuses = ['ordered', 'accepted', 'being_washed', 'ready_for_pickup', 'done'];
        abort_unless(in_array($status, $validStatuses, true), 422, 'Invalid status');

        $order->update(['status' => $status]);

        return redirect()->route('outlet.staff.order.show', $order)->with('success', 'Status updated');
    }
}
