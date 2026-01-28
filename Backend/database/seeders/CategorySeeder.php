<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Protein Powders',
            'Vitamins & Minerals',
            'Pre-Workout',
            'Post-Workout',
            'Fat Burners',
            'BCAA',
            'Creatine',
            'Water Bottles',
            'Gym Bags',
            'Shakers',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'parent_id' => null,
            ]);
        }
    }
}
