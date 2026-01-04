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
        'total',
        'customer_id',
        'outlet_id',
        'staff_id',
    ];

    protected $casts = [
        'payment_confirm' => 'bool',
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
}
