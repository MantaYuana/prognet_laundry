<?php

namespace App\Services;

use App\Models\LaundryService;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    public function create(array $data, ?int $staffId = null): Order
    {
        return DB::transaction(function () use ($data, $staffId) {
            $order = Order::create([
                'code' => 'ORD-' . Str::upper(Str::random(8)),
                'status' => 'ordered',
                'payment_confirm' => false,
                'address' => $data['address'] ?? '',
                'customer_id' => $data['customer_id'] ?? null,
                'outlet_id' => $data['outlet_id'],
                'staff_id' => $staffId,
                'total' => 0,
            ]);

            $total = 0;
            foreach ($data['items'] as $item) {
                $service = LaundryService::findOrFail($item['laundry_service_id']);
                $qty = $item['quantity'];
                $unit = $service->price;
                $subtotal = $unit * $qty;

                $order->items()->create([
                    'laundry_service_id' => $service->id,
                    'quantity' => $qty,
                    'item_price' => $unit,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            $order->update(['total' => $total]);

            return $order->load(['items.laundryService', 'customer']);
        });
    }
}