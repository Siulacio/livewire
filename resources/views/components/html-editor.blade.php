<div wire:ignore>
    <trix-editor
        x-on:trix-change="$dispatch('input', event.target.value)"
        {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm']) !!}
    >
    </trix-editor>
</div>
