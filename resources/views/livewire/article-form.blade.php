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
                    <div class="col-span-6 sm:col-span-4 relative">
                        @if($image)
                            <x-jet-danger-button wire:click="$set('image')" class="absolute bottom-2 right-2">
                                {{ __('Change Image') }}
                            </x-jet-danger-button>
                            <img src="{{ $image->temporaryUrl() }}" class="border-2 rounded">
                        @elseif($article->image)
                            <x-jet-label for="image" :value="__('Change Image')" class="absolute bottom-2 right-2 cursor-pointer inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"/>
                            <img src="{{ Storage::disk('public')->url($article->image) }}" class="border-2 rounded" alt="">
                        @else
                            <div class="h-32 bg-gray-50 border-2 border-dashed rounded flex items-center justify-center">
                                <x-jet-label for="image" :value="__('Select Image')" class="cursor-pointer inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"/>
                            </div>
                        @endif
                        <x-jet-input wire:model="image" id="image" class="hidden" type="file"/>
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
                        <x-jet-label for="content" :value="__('Content')"/>
                        <x-html-editor wire:model="article.content" id="content"
                                       class="mt-1 block w-full"></x-html-editor>
                        <x-jet-input-error for="article.content" class="mt-2"/>
                    </div>

                    <x-slot name="actions">
                        <x-jet-button>
                            {{ __('Save') }}
                        </x-jet-button>
                    </x-slot>
                </x-slot>

            </x-jet-form-section>
        </div>
    </div>
</div>
