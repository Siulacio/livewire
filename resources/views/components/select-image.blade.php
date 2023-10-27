@php($id = $attributes->wire('model')->value)

<div x-data="{ focused: false }" class="relative">
    @if($image instanceof \Livewire\TemporaryUploadedFile)
        <x-jet-danger-button wire:click="$set('{{$id}}')" class="absolute bottom-2 right-2">
            {{ __('Change Image') }}
        </x-jet-danger-button>
        <img src="{{ $image->temporaryUrl() }}" class="border-2 rounded">
    @elseif($existing)
        <label for="{{ $id }}"
             class="absolute bottom-2 right-2 cursor-pointer inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 disabled:opacity-25 transition"
             :class="{'outline-none border-gray-900 ring ring-gray-300': focused}"
        >{{ __('Change Image')  }}</label>
        <img src="{{ Storage::disk('public')->url($existing) }}" class="border-2 rounded" alt="">
    @else
        <div class="h-32 bg-gray-50 border-2 border-dashed rounded flex items-center justify-center">
            <label for="{{ $id }}"
               class="cursor-pointer inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 disabled:opacity-25 transition"
               :class="{'outline-none border-gray-900 ring ring-gray-300': focused}"
            >{{ __('Select Image') }}</label>
        </div>
    @endif
    @unless($image)
        <x-jet-input
            wire:model="{{$id}}"
            x-on:focus="focused = true"
            x-on:blur="focused = false"
            :id="$id"
            class="sr-only"
            type="file"
        />
    @endunless
</div>
