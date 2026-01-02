<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaundryService extends Model {
    use SoftDeletes;

    protected $table = 'laundry_services';

    protected $fillable = [
        'name',
        'service_type',
        'price',
    ];

    public function outlet() {
        return $this->belongsTo(Outlet::class);
    }
}
