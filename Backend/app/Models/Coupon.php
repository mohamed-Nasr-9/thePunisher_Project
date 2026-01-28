<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'discount',
        'max_usage',
        'used_count',
        'expires_at',
    ];

    protected $casts = [
        'discount' => 'decimal:2',
        'expires_at' => 'datetime',
    ];

    /**
     * Check if coupon is valid
     */
    public function isValid(): bool
    {
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($this->max_usage && $this->used_count >= $this->max_usage) {
            return false;
        }

        return true;
    }
}
