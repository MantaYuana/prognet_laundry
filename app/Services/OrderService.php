<?php

namespace App\Services;

use App\Models\LaundryService;
use App\Models\Order;
use App\Models\Promo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService {
    public function create(array $data, ?int $staffId = null): Order {
        return DB::transaction(function () use ($data, $staffId) {
            $subtotal = 0;
            $items = [];

            // --- LOOPING 1: Hitung & Siapkan Data ---
            foreach ($data['items'] as $item) {
                // Ambil data service dari DB berdasarkan ID yang dikirim Controller
                $service = LaundryService::findOrFail($item['laundry_service_id']); 
                
                $qty = $item['quantity'];
                $unit = $service->price;
                $itemSubtotal = $unit * $qty;

                // Kita simpan data yang RAPI ke array sementara
                $items[] = [
                    'service_object' => $service, // Kita simpan object aslinya biar gampang
                    'quantity' => $qty,
                    'item_price' => $unit,
                    'subtotal' => $itemSubtotal,
                ];

                $subtotal += $itemSubtotal;
            }

            // --- LOGIC PROMO ---
            $discountAmount = 0;
            $promo = null;

            // Cek logic promo (sudah benar, tapi kita rapikan dikit handle null-nya)
            if (!empty($data['promo_id'])) {
                // Kalau Controller sudah kirim ID promo (dari logic controller sebelumnya)
                $promo = Promo::find($data['promo_id']);
                $discountAmount = $data['discount_amount'] ?? 0;
            } 
            elseif (!empty($data['promo_code'])) {
                // Fallback kalau Controller cuma kirim kode (cara lama)
                $promo = Promo::where('promo_code', $data['promo_code'])
                    ->where('outlet_id', $data['outlet_id'])
                    ->first();

                if ($promo && $promo->isActive()) {
                    $discountAmount = $promo->calculateDiscount($subtotal);
                }
            }

            // Pastikan total tidak minus
            $total = max(0, $subtotal - $discountAmount);

            // --- SIMPAN ORDER UTAMA ---
            $order = Order::create([
                'code' => 'ORD-' . Str::upper(Str::random(8)),
                'status' => 'ordered',
                'payment_confirm' => false,
                'address' => $data['address'] ?? '',
                'customer_id' => $data['customer_id'] ?? null,
                'outlet_id' => $data['outlet_id'],
                'staff_id' => $staffId,
                
                // Data Promo
                'promo_id' => $promo?->id,
                'promo_code' => $promo?->promo_code,
                
                // Data Keuangan
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'total' => $total, // <--- Tadi kamu set 0, harusnya $total
            ]);

            // --- LOOPING 2: Simpan Detail Item (YANG TADI ERROR) ---
            foreach ($items as $item) {
                // PERBAIKAN DISINI: 
                // Kita tidak perlu cari ke DB lagi, karena sudah disimpan di 'service_object'
                
                $order->items()->create([
                    'laundry_service_id' => $item['service_object']->id, // Ambil ID dari object
                    'quantity' => $item['quantity'],
                    'item_price' => $item['item_price'], // Pastikan nama key sama
                    'subtotal' => $item['subtotal'],
                ]);
            }

            return $order->load(['items.laundryService', 'customer', 'promo']);
        });
    }

    public function validatePromo(string $promoCode, int $outletId, float $amount): ?array {
        $promo = Promo::where('promo_code', $promoCode)
            ->where('outlet_id', $outletId)
            ->first();

        if (!$promo) {
            return ['error' => 'Promo code not found'];
        }

        if (!$promo->isActive()) {
            return ['error' => 'Promo code is not active or has expired'];
        }

        $discount = $promo->calculateDiscount($amount);

        return [
            'valid' => true,
            'promo' => $promo,
            'discount_amount' => $discount,
            'final_total' => max(0, $amount - $discount),
        ];
    }
}
