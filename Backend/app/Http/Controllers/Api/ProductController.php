<?php

namespace App\Http\Controllers\Api;
use App\Services\ProductService;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Requests\Product\StoreProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService
    ) {}

    public function index()
    {
        $products = Product::with(['brand', 'images'])
            ->whereHas('variants', fn ($q) => $q->where('stock', '>', 0))
            ->paginate(20);

        return ProductResource::collection($products);
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['variants', 'images', 'brand', 'category'])
            ->firstOrFail();

        return new ProductResource($product);
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->create($request->validated());

        return new ProductResource(
            $product->load(['variants', 'images','category', 'brand'])
        );
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted']);
    }
}
