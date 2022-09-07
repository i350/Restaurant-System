<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IngredientStockActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'ingredient_id',
        'in',
        'out',
        'remaining',
        'comment',
    ];

    // ----------------------------------- Relationships
    public function ingredient(): BelongsTo
    {
        return $this->belongsTo(Ingredient::class);
    }
}
