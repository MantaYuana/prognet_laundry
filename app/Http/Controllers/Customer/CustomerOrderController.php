<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Outlet;
use App\Models\LaundryService;
use App\Services\OrderService;

class CustomerOrderController extends Controller {
    public function index() {
        $customer = Customer::where('user_id', auth()->id())->firstOrFail();

        $orders = Order::with(['outlet', 'items.laundryService'])
            ->where('customer_id', $customer->id)
            ->latest()
            ->paginate(10);

        return view('pages.customer.order.index', compact('orders'));
    }

    public function create(Outlet $outlet) {
        $services = LaundryService::where('outlet_id', $outlet->id)->get();

        if ($services->isEmpty()) {
            return redirect()
                ->route('customer.outlet.show', $outlet)
                ->with('error', 'This outlet has no services available yet.');
        }

        return view('pages.customer.order.create', compact('outlet', 'services'));
    }

    public function store(Request $request, Outlet $outlet, OrderService $order_service) {
        $customer = Customer::where('user_id', auth()->id())->firstOrFail();

        $data = $request->validate([
            'address' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.laundry_service_id' => 'required|exists:laundry_services,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $service_ids = collect($data['items'])->pluck('laundry_service_id');
        $valid_service = LaundryService::whereIn('id', $service_ids)
            ->where('outlet_id', $outlet->id)
            ->count();

        if ($valid_service !== $service_ids->count()) {
            return back()->withErrors(['items' => 'Invalid services selected for this outlet.']);
        }

        $data['customer_id'] = $customer->id;
        $data['outlet_id'] = $outlet->id;
        $data['address'] = $data['address'] ?? $customer->address;

        $order = $order_service->create($data);

        return redirect()
            ->route('customer.order.show', $order)
            ->with('success', 'Order created successfully! Order Code: ' . $order->code);
    }

    public function show(Order $order) {
        $customer = Customer::where('user_id', auth()->id())->firstOrFail();
        abort_if($order->customer_id !== $customer->id, 403);

        $order->load(['outlet', 'staff.profile', 'items.laundryService']);

        return view('pages.customer.order.show', compact('order'));
    }
}
