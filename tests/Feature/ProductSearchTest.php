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

    public function test_search_functionality()
    {
        $firstProduct = Product::factory()->create(['name' => 'Product A']);
        $secondProduct = Product::factory()->create(['name' => 'Product B']);

        Livewire::test(ProductSearch::class)
            ->set('search', 'A') 
            ->assertSee('Product A') 
            ->assertDontSee('Product B'); 
    }

    public function test_category_filter()
    {
        $firstCategory = Category::factory()->create();
        $secondCategory = Category::factory()->create();
        $firstProduct = Product::factory()->create();
        $secondProduct = Product::factory()->create();
        $firstProduct->categories()->attach($firstCategory);
        $secondProduct->categories()->attach($secondCategory);

        Livewire::test(ProductSearch::class)
            ->set('selectedCategory', [$firstCategory->id])
            ->assertSee($firstProduct->name) 
            ->assertDontSee($secondProduct->name);
    }

    public function test_brand_filter()
    {
        $firstBrand = Brand::factory()->create();
        $secondbrand = Brand::factory()->create();
        $firstProduct = Product::factory()->create();
        $secondProduct = Product::factory()->create();
        $firstProduct->brands()->attach($firstBrand);
        $secondProduct->brands()->attach($secondbrand);

        Livewire::test(ProductSearch::class)
            ->set('selectedBrand', [$firstBrand->id]) 
            ->assertSee($firstProduct->name) 
            ->assertDontSee($secondProduct->name); 
    }

    public function test_clear_filters()
    {
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();
        $product = Product::factory()->create();
        $product->categories()->attach($category);
        $product->brands()->attach($brand);

        Livewire::test(ProductSearch::class)
            ->set('search', 'Test')
            ->set('selectedCategory', [$category->id])
            ->set('selectedBrand', [$brand->id])
            ->call('clearFilters') 
            ->assertSet('search', '') 
            ->assertSet('selectedCategory', []) 
            ->assertSet('selectedBrand', []); 
    }
}