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
        $finalPrice = $this->price - ($this->price * ($this->discount_percentage / 100));
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => (float) $this->price,
            'discount_percentage' => (float) $this->discount_percentage,
            'final_price' => (float) $finalPrice,
            'stock_quantity' => $this->stock_quantity,
            'category' => [
                'id' => $this->category_id,
                'name' => $this->whenLoaded('category', function () {
                    return $this->category->name;
                }),
            ],
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
