<?php

namespace App\Http\Requests;

use App\Exceptions\NoEnoughIngredients;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    private Collection $computedProducts;
    private array $computedQuantities;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'products' => ['required', 'array'],
            'products.*.product_id' => ['required', 'exists:products,id'],
            'products.*.quantity' => ['required', 'integer'],
        ];
    }

    /**
     * Get collection of products.
     */
    public function getProducts(): Collection
    {
        return $this->computedProducts ??= Product::query()
            ->with(['product_ingredients', 'product_ingredients.ingredient'])
            ->findMany(array_column($this->validated('products'), 'product_id'));
    }

    /**
     * Get array of quantities per product.
     */
    public function getQuantities(): array
    {
        return $this->computedQuantities ??= collect($this->validated('products'))
            ->mapWithKeys(fn($cartItem) => [$cartItem['product_id'] => $cartItem['quantity']])
            ->all();
    }

    /**
     * Check if ingredients of the requested products are available in stock.
     *
     * @return void
     * @throws \Throwable
     */
    public function checkStockAvailability(): void
    {
        $quantities = $this->getQuantities();
        foreach($this->getProducts() as $product) {
            /** @var Product $product */
            throw_unless($product->hasEnoughStockFor($quantities[$product->getKey()]), new NoEnoughIngredients($product->name));
        }
    }
}
