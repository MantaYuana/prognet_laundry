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
use App\Models\Promo;

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

        // 1. Masukkan promo_code ke validasi agar datanya "ditangkap"
        $data = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'address' => 'nullable|string|max:255',
            'promo_code' => 'nullable|string|exists:promos,promo_code', // <--- TAMBAHAN
            'items' => 'required|array|min:1',
            'items.*.laundry_service_id' => 'required|exists:laundry_services,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Tentukan Outlet ID & Target Staff
        if ($user->hasRole('staff')) {
            $staff = Staff::where('user_id', $user->id)->first();
            $outletId = $staff->outlet_id; // Simpan di variabel biar gampang
            $data['outlet_id'] = $outletId;
            $target_staff_id = $staff->id;
        } else {
            $outletId = request()->route('outlet');
            $data['outlet_id'] = $outletId;
            $target_staff_id = null;
        }

        // --- 2. LOGIKA HITUNG PROMO (Mulai) ---
        // Kita perlu hitung total harga kasar dulu untuk tahu diskonnya
        $tempTotal = 0;
        foreach ($data['items'] as $item) {
            $service = LaundryService::find($item['laundry_service_id']);
            $tempTotal += $service->price * $item['quantity'];
        }

        $discountAmount = 0;
        $promoId = null;

        // Cek jika ada promo code
        if (!empty($data['promo_code'])) {
            $promo = Promo::where('promo_code', $data['promo_code'])
                          ->where('outlet_id', $outletId) // Pastikan promo milik outlet ini
                          ->active() // Pastikan status aktif & tanggal valid
                          ->first();

            if ($promo) {
                // Simpan ID Promo
                $promoId = $promo->id;
                
                // Hitung nominal diskon
                if ($promo->type == 'percentage') {
                    $discountAmount = ($tempTotal * $promo->value) / 100;
                    // Opsional: Batasi max diskon jika ada rule-nya
                } else {
                    $discountAmount = $promo->value;
                }

                // Pastikan diskon tidak melebihi total harga
                if ($discountAmount > $tempTotal) {
                    $discountAmount = $tempTotal;
                }
            }
        }

        // Masukkan data hasil hitungan ke array $data
        // Supaya OrderService bisa menyimpannya ke database
        $data['promo_id'] = $promoId;
        $data['discount_amount'] = $discountAmount;
        // Grand total biasanya dihitung ulang di Service, tapi kita kirim data pendukungnya
        // --- LOGIKA HITUNG PROMO (Selesai) ---

        // 3. Panggil Service untuk simpan ke database
        $orderService->create($data, $target_staff_id ?? null);

        // Redirect
        if ($user->hasRole('staff')) {
            return redirect()
                ->route('staff.orders.index')
                ->with('success', 'Order created successfully');
        } else {
            return redirect()
                ->route('outlet.staff.order.index')
                ->with('success', 'Order created successfully');
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
}
