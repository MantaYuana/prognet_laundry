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
        'user_id'
    ];

    public function outlets() {
        return $this->hasMany(Outlet::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
