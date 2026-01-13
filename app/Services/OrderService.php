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

            foreach ($data['items'] as $item) {
                $service = LaundryService::findOrFail($item['laundry_service_id']);
                $qty = $item['quantity'];
                $unit = $service->price;
                $itemSubtotal = $unit * $qty;

                $items[] = [
                    'service' => $service,
                    'quantity' => $qty,
                    'item_price' => $unit,
                    'subtotal' => $itemSubtotal,
                ];

                $subtotal += $itemSubtotal;
            }

            $discountAmount = 0;
            $promo = null;

            if (!empty($data['promo_code'])) {
                $promo = Promo::where('promo_code', $data['promo_code'])
                    ->where('outlet_id', $data['outlet_id'])
                    ->first();

                if ($promo && $promo->isActive()) {
                    $discountAmount = $promo->calculateDiscount($subtotal);
                }
            }

            $total = max(0, $subtotal - $discountAmount);

            $order = Order::create([
                'code' => 'ORD-' . Str::upper(Str::random(8)),
                'status' => 'ordered',
                'payment_confirm' => false,
                'address' => $data['address'] ?? '',
                'customer_id' => $data['customer_id'] ?? null,
                'outlet_id' => $data['outlet_id'],
                'staff_id' => $staffId,
                'promo_id' => $promo?->id,
                'promo_code' => $promo?->promo_code,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'total' => 0,
            ]);

            foreach ($items as $item) {
                $service = LaundryService::findOrFail($item['laundry_service_id']);
                $qty = $item['quantity'];
                $unit = $service->price;
                $subtotal = $unit * $qty;

                $order->items()->create([
                    'laundry_service_id' => $item['service']->id,
                    'quantity' => $item['quantity'],
                    'item_price' => $item['unit_price'],
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
