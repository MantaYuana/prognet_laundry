<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Owner extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'phone_number',
    ];

    public function owner_of() {
        return $this->hasMany(Outlet::class);
    }

    public function profile_of() {
        return $this->belongsTo(User::class);
    }
}
