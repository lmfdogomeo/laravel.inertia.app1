<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'sku' => $this->sku,
            'brand_name' => $this->brand_name,
            'product_name' => $this->product_name,
            'product_description' => $this->product_description,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'is_sale' => $this->is_sale,
            'quantity' => $this->quantity,
            'sale' => $this->sale,
            'stock_status' => $this->stock_status,
            'stock_quantity' => $this->stock_quantity,
            'sold_quantity' => $this->sold_quantity,
            'unit' => $this->unit,
            'start_date' => $this->start_date,
            'size' => $this->size,
            'weight' => $this->weight,
            'rate' => $this->rate,
            // 'category_id' => $this->category_id,
            // 'merchant_id' => $this->merchant_id,
            // 'category_id' => $this->category_id,
            // 'merchant_id' => $this->merchant_id,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
