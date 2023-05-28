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

    protected function rules(): array
    {
        return [
            'category.name' => ['required', 'string', 'min:3'],
        ];
    }

    public function openModal(): void
    {
        $this->showModal = true;
        $this->category = new Category();
    }

    public function updatedCategoryName()
    {
        $this->validateOnly('category.name');
    }

    public function save()
    {
        $this->validate();
        $this->category->save();
        $this->reset('showModal');
    }

    public function render(): View
    {
        $categories = Category::latest()
            ->paginate(10);

        return view('livewire.categories-list', [
            'categories' => $categories,
        ]);
    }
}
