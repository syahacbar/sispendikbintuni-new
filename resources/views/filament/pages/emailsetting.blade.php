<x-filament-panels::page>
    <x-filament-panels::form wire:submit.prevent="save">
        {{ $this->form }}

        <div class="flex justify-start mt-4 space-x-4">
            <x-filament::button type="submit">
                Perbarui
            </x-filament::button>

            <x-filament::button type="button" wire:click="testEmailConfig" color="secondary">
                Test Pengaturan Email
            </x-filament::button>
        </div>
    </x-filament-panels::form>
</x-filament-panels::page>