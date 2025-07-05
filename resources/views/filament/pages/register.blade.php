<x-filament::page>
    <form wire:submit.prevent="register" class="space-y-4">
        {{ $this->form }}

        <x-filament::button type="submit" class="w-full">
            Daftar
        </x-filament::button>

        <div class="text-center mt-4">
            <a href="{{ route('filament.admin.auth.login') }}" class="text-primary-600 hover:underline">
                Sudah punya akun? Login di sini
            </a>
        </div>
    </form>
</x-filament::page>