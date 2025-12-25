<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Outlet extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'phone_number',
    ];

    public function owner() {
        return $this->belongsTo(Owner::class);
    }

    public function staff() {
        return $this->hasMany(Staff::class);
    }

    public function user()
{
    return $this->belongsTo(User::class);
}

    public function services(){
        return $this->hasMany(LaundryService::class);
    }
}
