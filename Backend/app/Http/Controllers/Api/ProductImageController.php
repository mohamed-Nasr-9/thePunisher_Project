<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductImageController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'image'   => 'required|image|max:2048',
            'is_main' => 'sometimes|boolean',
        ]);

        return DB::transaction(function () use ($request, $product) {

            if ($request->boolean('is_main')) {
                $product->images()->update(['is_main' => false]);
            }

            $path = $request->file('image')->store('products', config('filesystems.default'));

            $image = $product->images()->create([
                'path'    => $path,
                'is_main' => $request->boolean('is_main'),
            ]);

            return response()->json($image, 201);
        });
    }

    public function destroy(Product $product, ProductImage $image)
    {
        abort_if($image->product_id !== $product->id, 404);

        Storage::disk(config('filesystems.default'))->delete($image->path);
        $image->delete();

        return response()->json(['message' => 'Image deleted']);
    }

    public function setMain(Product $product, ProductImage $image)
    {
        abort_if($image->product_id !== $product->id, 404);

        DB::transaction(function () use ($product, $image) {
            $product->images()->update(['is_main' => false]);
            $image->update(['is_main' => true]);
        });

        return response()->json(['message' => 'Main image updated']);
    }
}
