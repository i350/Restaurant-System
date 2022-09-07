<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // ----------------------------------- Relationships
    public function product_ingredients(): HasMany
    {
        return $this->hasMany(ProductIngredient::class);
    }

    // ----------------------------------- Methods
    public function hasEnoughStockFor($quantity = 1): bool
    {
        return $this->product_ingredients->every(function (ProductIngredient $productIngredient) use ($quantity) {
            return $productIngredient->ingredient->stock >= $quantity*$productIngredient->amount;
        });
    }
}
