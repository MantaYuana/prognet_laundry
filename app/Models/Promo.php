<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Promo extends Model {
    use HasFactory, SoftDeletes;
    protected $table = 'promos';

    protected $fillable = [
        'promo_code',
        'name',
        'description',
        'value',
        'type',
        'start_date',
        'end_date',
        'is_active',
        'outlet_id',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'value' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function outlet() {
        return $this->belongsTo(Outlet::class);
    }

    public function scopeActive(Builder $query): Builder {
        return $query->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    public function scopeExpired(Builder $query): Builder {
        return $query->where('end_date', '<', now());
    }

    public function scopeUpcoming(Builder $query): Builder {
        return $query->where('start_date', '>', now());
    }

    public function scopeForOutlet(Builder $query, int $outletId): Builder {
        return $query->where('outlet_id', $outletId);
    }

    public function isActive(): bool {
        return $this->is_active
            && $this->start_date <= now()
            && $this->end_date >= now();
    }

    public function isExpired(): bool {
        return $this->end_date < now();
    }

    public function calculateDiscount(float $amount): float {
        if (!$this->isActive()) {
            return 0;
        }

        if ($this->type === 'percentage') {
            return $amount * ($this->value / 100);
        }

        return min($this->value, $amount);
    }
}
