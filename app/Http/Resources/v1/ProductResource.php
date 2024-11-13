<?php

namespace App\Http\Resources\v1;

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
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'code' => $this->code,
            'brand' => $this->brand,
            'stock' => $this->stock,
            'price' => [
                'value' => $this->getRawOriginal('price'),
                'formattedValue' => $this->price,
            ],
            'description' => $this->when($request->routeIs('products.show'), $this->description),
            'links' => [
                'self' => route('products.show', ['product' => $this->slug])
            ]
        ];
    }
}
