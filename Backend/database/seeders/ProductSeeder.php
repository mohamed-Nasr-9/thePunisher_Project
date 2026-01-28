<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $brands = Brand::all();
        $categories = Category::all();

        $supplements = [
            [
                'name' => 'Whey Protein Powder',
                'description' => 'Premium whey protein isolate with 25g protein per serving',
                'flavors' => ['Vanilla', 'Chocolate', 'Strawberry', 'Cookies & Cream'],
                'sizes' => ['1kg', '2kg', '5kg'],
                'basePrice' => 1500,
            ],
            [
                'name' => 'Creatine Monohydrate',
                'description' => 'Pure creatine for muscle strength and power',
                'flavors' => ['Unflavored', 'Fruit Punch', 'Lemonade'],
                'sizes' => ['250g', '500g', '1kg'],
                'basePrice' => 800,
            ],
            [
                'name' => 'BCAA Energy Drink',
                'description' => 'Branched chain amino acids with energy boost',
                'flavors' => ['Tropical', 'Blue Raspberry', 'Watermelon', 'Green Apple'],
                'sizes' => ['30 servings', '60 servings'],
                'basePrice' => 1200,
            ],
            [
                'name' => 'Pre-Workout Intensifier',
                'description' => 'High-intensity pre-workout formula for endurance',
                'flavors' => ['Mango Surge', 'Grape Thunder', 'Citrus Blitz', 'Berry Blast'],
                'sizes' => ['20 servings', '40 servings', '60 servings'],
                'basePrice' => 1800,
            ],
            [
                'name' => 'Mass Gainer',
                'description' => 'High-calorie formula for muscle mass building',
                'flavors' => ['Vanilla Shake', 'Chocolate Delight', 'Strawberry Cream'],
                'sizes' => ['2kg', '4kg', '6kg'],
                'basePrice' => 2500,
            ],
            [
                'name' => 'Multivitamin Complex',
                'description' => 'Complete vitamin and mineral supplement',
                'flavors' => ['Orange', 'Lemon', 'Berry Mix'],
                'sizes' => ['30 tabs', '60 tabs', '90 tabs'],
                'basePrice' => 1000,
            ],
            [
                'name' => 'Fish Oil Omega-3',
                'description' => 'Premium fish oil supplement for joint and heart health',
                'flavors' => ['Lemon', 'Natural', 'Orange'],
                'sizes' => ['60 caps', '120 caps', '180 caps'],
                'basePrice' => 1100,
            ],
            [
                'name' => 'Fat Burner Thermogenic',
                'description' => 'Metabolism boosting fat burner supplement',
                'flavors' => ['Green Apple', 'Watermelon', 'Mango'],
                'sizes' => ['60 caps', '120 caps'],
                'basePrice' => 1400,
            ],
            [
                'name' => 'Amino Acid Complex',
                'description' => 'Essential and non-essential amino acids blend',
                'flavors' => ['Pineapple', 'Grape', 'Peach'],
                'sizes' => ['30 servings', '60 servings'],
                'basePrice' => 950,
            ],
            [
                'name' => 'Collagen Powder',
                'description' => 'Type I & III collagen for skin and joint health',
                'flavors' => ['Vanilla', 'Chocolate', 'Strawberry', 'Unflavored'],
                'sizes' => ['300g', '600g', '1kg'],
                'basePrice' => 1350,
            ],
        ];

        foreach ($supplements as $supplement) {
            $product = Product::create([
                'name' => $supplement['name'],
                'slug' => Str::slug($supplement['name'] . '-' . $faker->unique()->randomNumber(5)),
                'description' => $supplement['description'],
                'category_id' => $categories->random()->id,
                'brand_id' => $brands->random()->id,
            ]);

            // Create variants with flavors and sizes
            foreach ($supplement['flavors'] as $flavor) {
                foreach ($supplement['sizes'] as $size) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'sku' => strtoupper(Str::random(3)) . '-' . $product->id . '-' . substr(str_replace(' ', '', $flavor), 0, 3),
                        'flavor' => $flavor,
                        'size' => $size,
                        'price' => $supplement['basePrice'] + $faker->numberBetween(0, 500),
                        'stock' => $faker->numberBetween(10, 100),
                        'expiration_date' => now()->addMonths($faker->numberBetween(6, 24))->toDateString(),
                    ]);
                }
            }

            // Create product images
            for ($i = 1; $i <= 3; $i++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => 'supplements/' . Str::slug($supplement['name']) . '-' . $i . '.jpg',
                    'is_main' => $i === 1,
                ]);
            }
        }
    }
}

