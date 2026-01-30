<x-filament-panels::page>
    <x-filament-panels::form wire:submit.prevent="save">
        {{ $this->form }}

        <div class="flex justify-start mt-4 space-x-4">
            <x-filament::button type="submit" wire:loading.attr="disabled" wire:target="save">
                Perbarui
            </x-filament::button>

            <x-filament::button type="button" wire:click="testEmailConfig" color="secondary"
                wire:loading.attr="disabled" wire:target="testEmailConfig">
                Test Pengaturan Email
            </x-filament::button>
        </div>
    </x-filament-panels::form>
</x-filament-panels::page>