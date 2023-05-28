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
    public array $active = [];

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

    public function toggleIsActive(Category $category)
    {
        $category->update([
            'is_active' => $this->active[$category->id],
        ]);
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

        $this->active = $categories->mapWithKeys(
            fn (Category $item) => [$item['id'] => (bool) $item['is_active']]
        )->toArray();

        return view('livewire.categories-list', [
            'categories' => $categories,
        ]);
    }
}
