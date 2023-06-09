<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $editing ? 'Edit ' . $product->name : 'Create Product' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form wire:submit.prevent="save">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Name')" />

                            <x-text-input wire:model="product.name" id="name" class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('product.name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />

                            <div wire:ignore>
                                <textarea wire:model="product.description" data-description="@this" id="description" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                            </div>
                            <x-input-error :messages="$errors->get('product.description')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="price" :value="__('Price')" />

                            <x-text-input wire:model.defer="product.price" type="number" min="0" step="0.01" class="block mt-1 w-full" id="price" />
                            <x-input-error :messages="$errors->get('product.price')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label class="mb-1" for="categories" :value="__('Categories')" />

                            <x-choices wire:model="categories" class="mt-1" id="categories" name="categories" :options="$this->listsForFields['categories']" multiple />

                            <x-input-error :messages="$errors->get('categories')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label class="mb-1" for="country" :value="__('Country')" />
                            <x-select wire:model="product.country_id" id="country" name="country" :options="$this->listsForFields['countries']" />
                             <x-input-error :messages="$errors->get('product.country_id')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-primary-button type="submit">
                                Save
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>
    <script>
        const ready = (callback) => {
            if (document.readyState !== "loading") callback();
            else document.addEventListener("DOMContentLoaded", callback);
        }

        ready(() =>{
            ClassicEditor
                .create(document.querySelector('#description'))
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set('product.description', editor.getData());
                    });

                    Livewire.on('reinit', () => {
                        editor.setData('', '');
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        })
    </script>
@endpush
