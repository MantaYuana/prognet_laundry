<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'title',
        'address',
        'phone_number',
        'outlet_id',
        'user_id'
    ];

    public function outlet() {
        return $this->belongsTo(Outlet::class);
    }

    public function profile() {
        return $this->belongsTo(User::class);
    }
}
