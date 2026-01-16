<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\LaundryService;
use App\Models\Owner;
use App\Models\Staff;
use App\Services\OrderService;

class StaffOrderController extends Controller {
    public function index() {
        $user = auth()->user();

        if ($user->hasRole('staff')) {
            $staff = Staff::where('user_id', $user->id)->first();
            $orders = Order::with(['customer.profile', 'items.laundryService'])
                ->where('outlet_id', $staff->outlet_id)
                ->latest()
                ->paginate(15);
        } else {
            // NOTE: this for Owner bruv, later delete it yeah
            $outlet = request()->route('outlet');
            $orders = Order::with(['customer.profile', 'items.laundryService'])
                ->where('outlet_id', $outlet)
                ->latest()
                ->paginate(15);
        }

        return view('pages.outlet.order.staff.index', compact('orders'));
    }

    public function show(Order $order) {
        $user = auth()->user();

        if ($user->hasRole('staff')) {
            $staff = Staff::where('user_id', $user->id)->first();
            abort_if($order->outlet_id !== $staff->outlet_id, 403);
        }

        // NOTE: again this for owner bruv, pls change after there is controller for owner
        if ($user->hasRole('owner')) {
            $owner = Owner::where('user_id', $user->id)->first();
            abort_if($order->outlet_id !== $owner->outlet_id, 403);
        }

        $order->load(['customer', 'items.laundryService']);
        return view('pages.outlet.order.staff.show', compact('order'));
    }


    public function create() {
        $user = auth()->user();

        if ($user->hasRole('staff')) {
            $staff = Staff::where('user_id', $user->id)->first();
            $staff_outlet_id = $staff->outlet_id;
        } else {
            $staff_outlet_id = request()->route('outlet');
        }

        $customers = Customer::with('profile')->get();
        $services = LaundryService::where('outlet_id', $staff_outlet_id)->get();

        return view('pages.outlet.order.staff.create', compact('customers', 'services'));
    }

    public function store(Request $request, OrderService $orderService) {
        $user = auth()->user();

        $data = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'address' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'promo_code' => 'nullable|string|max:20',
            'items.*.laundry_service_id' => 'required|exists:laundry_services,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        if ($user->hasRole('staff')) {
            $staff = Staff::where('user_id', $user->id)->first();
            $data['outlet_id'] = $staff->outlet_id;
            $target_staff_id = $staff->id;
        } else {
            $data['outlet_id'] = request()->route('outlet');
            $target_staff_id = null;
        }

        $orderService->create($data, $target_staff_id ?? null);

        if ($user->hasRole('staff')) {
            return redirect()
                ->route('staff.orders.index')
                ->with('success', 'Order created');
        } else {
            return redirect()
                ->route('outlet.staff.order.index')
                ->with('success', 'Order created');
        }
    }

    // TODO: maybe add a feature to edit order details? but damn it gonna be hard bruv
    public function update(Request $request, Order $order) {
        $user = auth()->user();

        if ($user->hasRole('staff')) {
            $staff = Staff::where('user_id', $user->id)->first();
            abort_if($order->outlet_id !== $staff->outlet_id, 403);
        }

        // NOTE: again this for owner bruv, pls change after there is controller for owner
        if ($user->hasRole('owner')) {
            $owner = Owner::where('user_id', $user->id)->first();
            abort_if($order->outlet_id !== $owner->outlet_id, 403);
        }

        if ($request->has('status')) {
            $validStatuses = ['ordered', 'accepted', 'being_washed', 'ready_for_pickup', 'done'];
            $status = $request->input('status');

            abort_unless(in_array($status, $validStatuses, true), 422, 'Invalid status');

            $order->update(['status' => $status]);

            $route = $user->hasRole('staff') ? 'staff.orders.show' : 'outlet.staff.order.show';
            $params = $user->hasRole('staff') ? ['order' => $order->id] : [
                'outlet' => request()->route('outlet'),
                'staff' => request()->route('staff'),
                'order' => $order->id,
            ];

            return redirect()->route($route, $params)->with('success', 'Status updated successfully');
        }

        return back()->with('error', 'Invalid request');
    }

    // QUESTION: do we need updateStatus ?
    public function updateStatus(Request $request, Order $order, string $status) {
        $validStatuses = ['ordered', 'accepted', 'being_washed', 'ready_for_pickup', 'done'];
        abort_unless(in_array($status, $validStatuses, true), 422, 'Invalid status');

        $order->update(['status' => $status]);

        return redirect()->route('outlet.staff.order.show', $order)->with('success', 'Status updated');
    }

    public function approvePayment(Order $order) {
        $user = auth()->user();
        if ($user->hasRole('staff')) {
            $staff = Staff::where('user_id', $user->id)->first();
            abort_if($order->outlet_id !== $staff->outlet_id, 403);
        }
        $order->update([
            'payment_status' => 'paid',
            'payment_confirm' => true,
            'paid_at' => now(),
        ]);

        return back()->with('success', 'Payment approved');
    }

    public function rejectPayment(Order $order) {
        $user = auth()->user();
        if ($user->hasRole('staff')) {
            $staff = Staff::where('user_id', $user->id)->first();
            abort_if($order->outlet_id !== $staff->outlet_id, 403);
        }

        $order->update([
            'payment_status' => 'rejected',
            'payment_confirm' => false,
        ]);

        return back()->with('success', 'Payment rejected');
    }

    public function validatePromo(Request $request, OrderService $orderService) {
        $user = auth()->user();
        $staff = Staff::where('user_id', $user->id)->first();

        $validated = $request->validate([
            'promo_code' => 'required|string|max:20',
            'amount' => 'required|numeric|min:0',
        ]);

        $result = $orderService->validatePromo(
            $validated['promo_code'],
            $staff->outlet_id,
            $validated['amount']
        );

        if (isset($result['error'])) {
            return response()->json([
                'success' => false,
                'message' => $result['error']
            ], 422);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'promo_name' => $result['promo']->name,
                'promo_description' => $result['promo']->description,
                'promo_type' => $result['promo']->type,
                'promo_value' => $result['promo']->value,
                'discount_amount' => $result['discount_amount'],
                'subtotal' => $validated['amount'],
                'final_total' => $result['final_total'],
            ]
        ]);
    }

    public function validatePromoForOutlet(Request $request, $outlet, OrderService $orderService) {
        $validated = $request->validate([
            'promo_code' => 'required|string|max:20',
            'amount' => 'required|numeric|min:0',
        ]);

        $result = $orderService->validatePromo(
            $validated['promo_code'],
            $outlet,
            $validated['amount']
        );

        if (isset($result['error'])) {
            return response()->json([
                'success' => false,
                'message' => $result['error']
            ], 422);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'promo_name' => $result['promo']->name,
                'promo_description' => $result['promo']->description,
                'promo_type' => $result['promo']->type,
                'promo_value' => $result['promo']->value,
                'discount_amount' => $result['discount_amount'],
                'subtotal' => $validated['amount'],
                'final_total' => $result['final_total'],
            ]
        ]);
    }
}
