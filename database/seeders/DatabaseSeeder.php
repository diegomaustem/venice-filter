<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Brand::factory(5)->create();
        Category::factory(5)->create();

        // criar 20 produtos e relacionar com a tabela category_product e brand_product
        Product::factory(20)->create()->each(function ($product) {
            $brands = Brand::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $categories = Category::inRandomOrder()->take(rand(1, 3))->pluck('id');
        
            $product->brands()->attach($brands, ['created_at' => now(), 'updated_at' => now(),]);
            $product->categories()->attach($categories, ['created_at' => now(), 'updated_at' => now(),]);
        });
    }
}
