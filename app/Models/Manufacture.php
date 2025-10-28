<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Manufacture extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'quantity',
        'manufactured_at',
    ];

    protected $casts = [
        'manufactured_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function usages(): HasMany
    {
        return $this->hasMany(ManufactureUsage::class);
    }
}
