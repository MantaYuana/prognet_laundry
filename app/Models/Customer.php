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
        // NOTE: tf ??? what does added a column name do ????
        return $this->belongsTo(User::class, "user_id");
    }
}
