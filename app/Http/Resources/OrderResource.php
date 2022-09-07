<?php

namespace App\Http\Resources;

use App\Models\OrderItem;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $result = parent::toArray($request);
        if(!is_array($this->resource))  {
            $result['products'] = $this->resource->order_items()->with('product')->get()->map(fn (OrderItem $orderItem) => [
                'product_id' => $orderItem->product_id,
                'product_name' => $orderItem->product->name,
                'quantity' => $orderItem->quantity,
            ]);
        }
        return $result;
    }
}
