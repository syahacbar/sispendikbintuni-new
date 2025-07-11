<x-filament-panels::page>
    <x-filament-panels::form wire:submit.prevent="save">
        {{ $this->form }}

        <div class="flex justify-start mt-4">
            <x-filament::button type="submit" wire:loading.attr="disabled" wire:target="save" loading-indicator="save">
                Update Pengaturan API
            </x-filament::button>
        </div>
    </x-filament-panels::form>
</x-filament-panels::page>
