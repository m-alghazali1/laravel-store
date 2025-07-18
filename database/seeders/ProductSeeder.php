<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Faker\Provider\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory(20)->create();
    }
}
