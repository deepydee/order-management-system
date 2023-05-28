<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class CategoriesList extends Component
{
    use WithPagination;

    public Category $category;
    public Collection $categories;
    public bool $showModal = false;
    public array $active = [];
    public int $editedCategoryId = 0;
    public int $currentPage = 1;
    public int $perPage = 10;

    protected $listeners = ['delete'];

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

    public function updatedCategoryName(): void
    {
        $this->validateOnly('category.name');
    }

    public function toggleIsActive(Category $category): void
    {
        $category->update([
            'is_active' => $this->active[$category->id],
        ]);
    }

    public function updateOrder($list)
    {
        // dd($list);
        foreach ($list as $item) {
            $cat = $this->categories->firstWhere('id', $item['value']);
            $order = $item['order'] + ($this->currentPage - 1) * $this->perPage;

            if ($cat['position'] !== $order) {
                Category::whereId($item['value'])->update([
                    'position' => $order,
                ]);
            }
        }
    }

    public function save(): void
    {
        $this->validate();
        $this->category->position = Category::max('position') + 1;
        $this->category->save();
        $this->reset('showModal');
    }

    public function render(): View
    {
        $cats = Category::orderBy('position')->paginate($this->perPage);
        $links = $cats->links();
        $this->currentPage = $cats->currentPage();
        $this->categories = collect($cats->items());

        $this->active = $this->categories->mapWithKeys(
            fn (Category $item) => [$item['id'] => (bool) $item['is_active']]
        )->toArray();

        return view('livewire.categories-list', [
            'links' => $links,
        ]);
    }
}
