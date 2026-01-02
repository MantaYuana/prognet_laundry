<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model {
    use HasFactory, SoftDeletes;
    protected $table = 'customers';

    protected $fillable = [
        'address',
        'phone_number',
        'user_id',
    ];

    public function profile() {
        return $this->belongsTo(User::class);
    }
}
