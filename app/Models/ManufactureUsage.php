<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManufactureUsage extends Model
{
    protected $fillable = [
        'manufacture_id',
        'inventory_item_id',
        'quantity',
    ];

    public function manufacture(): BelongsTo
    {
        return $this->belongsTo(Manufacture::class);
    }

    public function inventoryItem(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class);
    }
}
