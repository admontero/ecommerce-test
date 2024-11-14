<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class OrderDTO
{
    public function __construct(
        public readonly string|null $status,
        public readonly array $items,
    )
    {
        //
    }

    public static function fromStoreRequest(Request $request): self
    {
        return new self(
            status: null,
            items: $request->input('items'),
        );
    }

    public static function fromUpdateRequest(Request $request): self
    {
        return new self(
            status: $request->input('status'),
            items: $request->input('items'),
        );
    }
}


