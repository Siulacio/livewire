<div>
    <x-jet-confirmation-modal wire:model="showDeleteModal">
        <x-slot name="title">Are you sure?</x-slot>
        <x-slot name="content">Do you want to delete this article: <b>{{$article->title}}</b> ?</x-slot>
        <x-slot name="footer">
            <x-jet-button wire:click.prevent="$set('showDeleteModal', false)" class="mr-auto">{{ __('Cancel') }}</x-jet-button>
            <x-jet-danger-button wire:click.prevent="delete" >{{ __('Confirm') }}</x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
