<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'unit_cost',
    ];

    public function components(): HasMany
    {
        return $this->hasMany(ProductComponent::class);
    }
}
