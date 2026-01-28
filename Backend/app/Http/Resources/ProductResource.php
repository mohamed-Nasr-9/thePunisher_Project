<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $mainImage = $this->whenLoaded('images')
            ? $this->images->firstWhere('is_main', true)
            : null;
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'slug'        => $this->slug,
            'description' => $this->description,

            'category' => [
                'id'   => $this->category_id,
                'name' => optional($this->category)->name,
            ],

            'brand' => [
                'id'   => $this->brand_id,
                'name' => optional($this->brand)->name,
            ],

            'variants' => ProductVariantResource::collection(
                $this->whenLoaded('variants')
            ),

            'images' => ProductImageResource::collection(
                $this->whenLoaded('images')
            ),

            'main_image' => $mainImage && $mainImage->path
                ? Storage::url($mainImage->path)
                : null,

            'rating' => round($this->reviews()->avg('rating'), 1),
        ];
    }
}
