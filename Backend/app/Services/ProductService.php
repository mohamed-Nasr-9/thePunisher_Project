<?php

namespace App\Services;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function create(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            $product = Product::create([
                'name'        => $data['name'],
                'slug'        => Str::slug($data['name']),
                'description' => $data['description'] ?? null,
                'category_id' => $data['category_id'],
                'brand_id'    => $data['brand_id'],
            ]);

            foreach ($data['variants'] as $variant) {
                $product->variants()->create($variant);
            }

            return $product;
        });
    }
}
