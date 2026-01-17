<x-filament-panels::page.simple>
    <div class="fi-simple-page">
        @if (filament()->hasLogin())
            <x-slot name="subheading">
                <p class="text-sm text-gray-600 dark:text-gray-400 text-center">
                    Selamat datang! Untuk melanjutkan, silakan pilih sekolah yang Anda kelola.
                </p>
            </x-slot>
        @endif

        <x-filament-panels::form wire:submit="submit">
            {{ $this->form }}

            <x-filament-panels::form.actions :actions="$this->getCachedFormActions()"
                :full-width="$this->hasFullWidthFormActions()" />
        </x-filament-panels::form>
    </div>
</x-filament-panels::page.simple>