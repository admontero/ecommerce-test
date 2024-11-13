<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'price' => [
                'value' => $this->getRawOriginal('price'),
                'formattedValue' => $this->price,
            ],
            'quantity' => $this->quantity,
            'total' => [
                'value' => $this->getRawOriginal('total'),
                'formattedValue' => $this->total,
            ],
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
