<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            'Optimum Nutrition',
            'MuscleTech',
            'Dymatize',
            'BSN',
            'Universal Nutrition',
            'MusclePharm',
            'Cellucor',
            'ALLMAX Nutrition',
            'Isopure',
            'ProteinSeries',
        ];

        foreach ($brands as $brand) {
            Brand::create([
                'name' => $brand,
            ]);
        }
    }
}
