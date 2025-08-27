<x-filament::page>
    <form wire:submit.prevent="send" class="space-y-4">
        {{ $this->form }}
        <x-filament::button type="submit">
            Kirim Sekarang
        </x-filament::button>
    </form>
</x-filament::page>
