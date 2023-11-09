<div>
    <x-confirmation-modal wire:model.live="showDeleteModal">
        <x-slot name="title">Are you sure?</x-slot>
        <x-slot name="content">Do you want to delete this article: <b>{{$article->title}}</b> ?</x-slot>
        <x-slot name="footer">
            <x-button wire:click.prevent="$set('showDeleteModal', false)" class="mr-auto">{{ __('Cancel') }}</x-button>
            <x-danger-button wire:click.prevent="delete" >{{ __('Confirm') }}</x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
