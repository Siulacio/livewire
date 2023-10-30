@php use Illuminate\Support\Facades\Storage; @endphp
<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New article') }}
        </h2>
    </x-slot>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <x-jet-form-section submit="save">
                <x-slot name="title">{{ __('New article') }}</x-slot>
                <x-slot name="description">{{ __('Some description') }}</x-slot>

                <x-slot name="form">
                    <div class="col-span-6 sm:col-span-4">
                        <x-select-image wire:model="image" :image="$image" :existing="$article->image"/>
                        <x-jet-input-error for="image" class="mt-2"/>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="title" :value="__('Title')"/>
                        <x-jet-input wire:model="article.title" id="title" class="mt-1 block w-full" type="text"/>
                        <x-jet-input-error for="article.title" class="mt-2"/>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="slug" :value="__('Slug')"/>
                        <x-jet-input wire:model="article.slug" id="slug" class="mt-1 block w-full" type="text"/>
                        <x-jet-input-error for="article.slug" class="mt-2"/>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="category_id" :value="__('Category')"/>
                        <div class="flex space-x-2 mt-1">
                            <x-select wire:model="article.category_id" :options="$categories" id="category_id" :placeholder="__('Select category')" class="block w-full"/>
                            <x-jet-secondary-button wire:click="openCategoryForm" class="!p-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </x-jet-secondary-button>
                        </div>
                        <x-jet-input-error for="article.category_id" class="mt-2"/>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="content" :value="__('Content')"/>
                        <x-html-editor wire:model="article.content" id="content"
                                       class="mt-1 block w-full"></x-html-editor>
                        <x-jet-input-error for="article.content" class="mt-2"/>
                    </div>

                    <x-slot name="actions">
                        <x-jet-danger-button wire:click="$set('showDeleteModal', true)" class="mr-auto">
                            {{ __('Delete') }}
                        </x-jet-danger-button>
                        <x-jet-button>
                            {{ __('Save') }}
                        </x-jet-button>
                    </x-slot>
                </x-slot>

            </x-jet-form-section>
        </div>
    </div>
    <x-jet-confirmation-modal wire:model="showDeleteModal">
        <x-slot name="title">Are you sure?</x-slot>
        <x-slot name="content">Do you want to delete this article: <b>{{$article->title}}</b> ?</x-slot>
        <x-slot name="footer">
            <x-jet-button wire:click="$set('showDeleteModal', false)">{{ __('Cancel') }}</x-jet-button>
            <x-jet-danger-button wire:click="delete" >{{ __('Confirm') }}</x-jet-danger-button>
        </x-slot>

    </x-jet-confirmation-modal>
    <x-jet-modal wire:model="showCategoryModal">
        <form wire:submit.prevent="saveNewCategory">
            <div class="px-6 py-4">
                <div class="text-lg">
                    {{ __('New Category') }}
                </div>

                <div class="mt-4 space-y-3">
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="new-category-name" :value="__('Name')"/>
                        <x-jet-input wire:model="newCategory.name" id="new-category-name" class="mt-1 block w-full" type="text"/>
                        <x-jet-input-error for="newCategory.name" class="mt-2"/>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="new-category-slug" :value="__('Slug')"/>
                        <x-jet-input wire:model="newCategory.slug" id="new-category-slug" class="mt-1 block w-full" type="text"/>
                        <x-jet-input-error for="newCategory.slug" class="mt-2"/>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-100 text-right space-x-2">
                <x-jet-secondary-button wire:click="closeCategoryForm">Cancel</x-jet-secondary-button>
                <x-jet-button>{{ __('Submit') }}</x-jet-button>
            </div>
        </form>
    </x-jet-modal>
</div>
