<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class CategoriesList extends Component
{
    use WithPagination;

    public Category $category;
    public bool $showModal = false;

    public function openModal(): void
    {
        $this->showModal = true;
        $this->category = new Category();
    }

    public function render(): View
    {
        $categories = Category::paginate(10);

        return view('livewire.categories-list', [
            'categories' => $categories,
        ]);
    }
}
