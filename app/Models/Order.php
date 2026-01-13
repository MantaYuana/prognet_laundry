<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model {
    use SoftDeletes;
    protected $table = 'orders';

    public const STATUSES = [
        'ordered',
        'accepted',
        'being_washed',
        'ready_for_pickup',
        'done',
    ];

    protected $fillable = [
        'code',
        'status',
        'payment_confirm',
        'payment_method',
        'payment_status',
        'payment_proof_path',
        'proof',
        'address',
        'subtotal',
        'discount_amount',
        'total',
        'promo_id',
        'promo_code',
        'customer_id',
        'outlet_id',
        'staff_id',
    ];

    protected $casts = [
        'payment_confirm' => 'bool',
        'subtotal' => 'integer',
        'discount_amount' => 'decimal:2',
        'total' => 'integer'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function outlet() {
        return $this->belongsTo(Outlet::class);
    }

    public function staff() {
        return $this->belongsTo(Staff::class);
    }

    public function items() {
        return $this->hasMany(OrderDetail::class);
    }

    public function promo() {
        return $this->belongsTo(Promo::class);
    }

    public function calculateTotal(): int {
        return max(0, $this->subtotal - (int)($this->discount_amount * 100));
    }
}
