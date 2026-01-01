<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model {
    protected $table = 'order_details';

    protected $fillable = [
        'quantity',
        'item_price',
        'subtotal',
        'laundry_service_id',
        'order_id',
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function laundryService() {
        return $this->belongsTo(LaundryService::class);
    }
}
