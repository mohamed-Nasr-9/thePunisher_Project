<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id'              => $this->id,
            'sku'             => $this->sku,
            'flavor'          => $this->flavor,
            'size'            => $this->size,
            'price'           => $this->price,
            'stock'           => $this->stock,
            'expiration_date' => optional($this->expiration_date)->toDateString(),
            'in_stock'        => $this->stock > 0,
        ];
    }
}
