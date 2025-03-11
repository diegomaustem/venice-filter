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
        $products = $this->getFilteredProducts();

        $categories = Category::all();
        $brands = Brand::all();

        return view('livewire.product-search', compact('products', 'categories', 'brands'));
    }

    private function getFilteredProducts()
    {
        $selectedCategories = $this->selectedCategory;
        $selectedBrands = $this->selectedBrand;

        $query = Product::query()
            ->when($this->search, function ($query) {
                $query->whereRaw('unaccent(lower(name)) ilike unaccent(lower(?))', ['%' . $this->search . '%']);
            })
            ->orderBy('name', 'asc');

        $query = $query->when(!empty($selectedCategories), function ($query) use ($selectedCategories) {
            $query->whereHas('categories', function ($query) use ($selectedCategories) {
                $query->whereIn('categories.id', $selectedCategories);
            });
        });

        $query = $query->when(!empty($selectedBrands), function ($query) use ($selectedBrands) {
            $query->whereHas('brands', function ($query) use ($selectedBrands) {
                $query->whereIn('brands.id', $selectedBrands);
            });
        });

        return $query->with(['categories', 'brands'])->get();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'selectedCategory', 'selectedBrand']);
    }
}
