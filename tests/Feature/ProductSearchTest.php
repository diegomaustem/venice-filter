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

    public function test_component_is_rendered()
    {
        Livewire::test(ProductSearch::class)
            ->assertSee('Pesquisar...');
    }

    public function test_search_functionality()
    {
        $product = Product::factory()->create(['name' => 'Product testing']);

        Livewire::test(ProductSearch::class)
            ->set('search', 'Test')
            ->assertSee('Product testing') 
            ->assertDontSee('Other Product'); 
    }
}