<x-filament-panels::page>

    <form wire:submit="save">

        {{ $this->form }}

        <div class="flex justify-end mt-6">
            <x-filament::button
                type="submit"
                color="success"
                icon="heroicon-o-check"
                wire:loading.attr="disabled"
            >
                {{ __('admin.settings.save_button') }}
            </x-filament::button>
        </div>

    </form>

</x-filament-panels::page>
