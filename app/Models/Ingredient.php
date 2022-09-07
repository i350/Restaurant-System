<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'stock',
        'low_threshold',
        'notified_low_stock',
        'notified_out_of_stock',
    ];

    // ----------------------------------- Relationships
    public function stock_activities(): HasMany
    {
        return $this->hasMany(IngredientStockActivity::class);
    }
}
