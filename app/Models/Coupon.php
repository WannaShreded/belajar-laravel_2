<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'min_order',
        'expires_at',
        'usage_limit',
        'used_count',
        'is_active',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_order' => 'decimal:2',
        'expires_at' => 'datetime',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Check if coupon is valid
     */
    public function isValid(): bool
    {
        return $this->is_active
            && (!$this->expires_at || $this->expires_at->isFuture())
            && (!$this->usage_limit || $this->used_count < $this->usage_limit);
    }

    /**
     * Check if coupon meets minimum order requirement
     */
    public function meetsMinimumOrder($orderTotal): bool
    {
        return $orderTotal >= $this->min_order;
    }

    /**
     * Calculate discount amount for given order total
     */
    public function calculateDiscount($orderTotal): float
    {
        if ($this->discount_type === 'percent') {
            return ($orderTotal * $this->discount_value) / 100;
        }

        return min($this->discount_value, $orderTotal);
    }

    /**
     * Increment usage count
     */
    public function incrementUsage(): void
    {
        $this->increment('used_count');
    }

    /**
     * Scope: Get active coupons
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Get valid coupons (not expired and within usage limit)
     */
    public function scopeValid($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit')
                  ->orWhereRaw('used_count < usage_limit');
            });
    }

    /**
     * Scope: Get expired coupons
     */
    public function scopeExpired($query)
    {
        return $query->where('is_active', false)
            ->orWhere('expires_at', '<=', now());
    }

    /**
     * Find coupon by code
     */
    public static function findByCode(string $code): ?self
    {
        return self::where('code', strtoupper($code))->first();
    }
}
