<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Outlet extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'owner_id'
    ];

    public function owner() {
        return $this->belongsTo(Owner::class);
    }

    public function staff() {
        return $this->hasMany(Staff::class);
    }

    public function services() {
        return $this->hasMany(LaundryService::class);
    }
}
