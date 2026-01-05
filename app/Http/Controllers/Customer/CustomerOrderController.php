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
    public function index(Request $request) {
        $customer = Customer::where('user_id', auth()->id())->firstOrFail();

        $filters = $request->validate([
            'status' => 'nullable|in:' . implode(',', Order::STATUSES),
            'code' => 'nullable|string|max:50',
            'from' => 'nullable|date',
            'to' => 'nullable|date',
        ]);

        $orders = Order::with(['outlet', 'items.laundryService'])
            ->where('customer_id', $customer->id)
            ->when($filters['status'] ?? null, fn($q, $status) => $q->where('status', $status))
            ->when($filters['code'] ?? null, fn($q, $code) => $q->where('code', 'like', '%' . $code . '%'))
            ->when($filters['from'] ?? null, fn($q, $from) => $q->whereDate('created_at', '>=', $from))
            ->when($filters['to'] ?? null, fn($q, $to) => $q->whereDate('created_at', '<=', $to))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // NOTE: suud be nganggo compact biin ruh usak gen to nok cicing
        return view('pages.customer.order.index', [
            'orders' => $orders,
            'statuses' => Order::STATUSES,
            'filters' => $filters,
        ]);
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

        if ($valid_service !== $service_ids->unique()->count()) {
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

    public function uploadPaymentProof(Request $request, Order $order) {
        $customer = Customer::where('user_id', auth()->id())->firstOrFail();
        abort_if($order->customer_id !== $customer->id, 403);

        $data = $request->validate([
            'payment_method' => 'required|string|max:50',
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        $path = $request->file('proof')->store('payment-proofs', 'public');

        $order->update([
            'payment_method' => $data['payment_method'],
            'payment_status' => 'pending',
            'payment_proof_path' => $path,
            'payment_confirm' => true
        ]);

        return back()->with('success', 'Payment proof uploaded. Awaiting verification.');
    }
}
