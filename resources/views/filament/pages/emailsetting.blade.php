<x-filament-panels::page>
    <x-filament-panels::form wire:submit.prevent="save">
        {{ $this->form }}

        <div class="flex justify-start mt-4 space-x-4">
            <x-filament::button type="submit">
                Update Settings
            </x-filament::button>

            <x-filament::button type="button" wire:click="testEmailConfig" color="secondary">
                Test Email Configuration
            </x-filament::button>
        </div>
    </x-filament-panels::form>
</x-filament-panels::page>