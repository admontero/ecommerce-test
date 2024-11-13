<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

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
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'code' => $this->code,
            'brand' => $this->brand,
            'stock' => $this->stock,
            'price' => [
                'value' => $this->price,
                'formattedValue' => Number::currency($this->price, 'COP'),
            ],
            'description' => $this->when($request->routeIs('products.show'), $this->description),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'links' => [
                'self' => route('products.show', ['product' => $this->slug])
            ]
        ];
    }
}
