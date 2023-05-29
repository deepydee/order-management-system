<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Country;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Redirector;

class ProductForm extends Component
{
    public Product $product;
    public bool $editing = false;
    public array $categories = [];
    public array $listsForFields = [];

    protected $casts = [
        'product.country_id' => 'integer',
    ];

    protected function rules(): array
    {
        return [
            'product.name' => ['required', 'string', 'min:3'],
            'product.description' => ['required', 'string', 'min:3'],
            'product.country_id' => ['required', 'integer', 'exists:countries,id'],
            'product.price' => ['required'],
            'categories' => ['required', 'array']
        ];
    }

    public function mount(Product $product): void
    {
        $this->product = $product;
        $this->initListsForFields();

        if ($this->product->exists) {
            $this->editing = true;

            $this->product->price = number_format($this->product->price / 100, 2);

            $this->categories = $this->product->categories()
                ->pluck('id')->toArray();
        }
    }

    public function updatedProductName()
    {
        $this->validateOnly('product.name');
    }

    public function updatedProductDescription()
    {
        $this->validateOnly('product.description');
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['countries'] = Country::pluck('name', 'id')
            ->toArray();

        $this->listsForFields['categories'] = Category::active()
            ->pluck('name', 'id')->toArray();
    }

    public function save(): RedirectResponse|Redirector
    {
        $this->validate();
        $this->product->price = $this->product->price * 100;

        $this->product->save();

        $this->product->categories()->sync($this->categories);

        $message = $this->editing ? 'edited': 'created';

        return redirect()->route('products.index')
            ->with('message', 'Product was successfully '. $message);
    }

    public function render()
    {
        return view('livewire.product-form');
    }
}
