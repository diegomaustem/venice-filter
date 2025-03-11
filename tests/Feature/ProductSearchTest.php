<?php

namespace Tests\Feature;

use App\Livewire\ProductSearch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_render_initial_state()
    {
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();
        $product = Product::factory()->create();
        $product->categories()->attach($category);
        $product->brands()->attach($brand);

        Livewire::test(ProductSearch::class)
            ->assertSee($product->name) 
            ->assertSee($category->name) 
            ->assertSee($brand->name);
    }
}