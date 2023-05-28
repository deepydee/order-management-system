<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsList extends Component
{
    use WithPagination;

    public function render(): View
    {
        $products = Product::paginate(10);

        return view('livewire.products-list', [
            'products' => $products,
        ]);
    }
}
