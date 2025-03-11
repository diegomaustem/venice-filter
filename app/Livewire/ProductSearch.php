<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class ProductSearch extends Component
{

    public $search = '';
    public array $selectedCategory = [];
    public array $selectedBrand = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => []],
        'selectedBrand' => ['except' => []],
    ];
    
    public function render()
    {
        // Teste consultas ::: 
        $products = Product::all();

        $categories = Category::all();
        $brands = Brand::all();


        return view('livewire.product-search', compact('products', 'categories', 'brands'));
    }
}
