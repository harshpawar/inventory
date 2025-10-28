<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryItem extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'unit',
        'stock',
        'description',
    ];

    public function productComponents(): HasMany
    {
        return $this->hasMany(ProductComponent::class);
    }
}
