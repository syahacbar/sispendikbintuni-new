<x-filament-panels::page.simple>
    @if (filament()->hasRegistration())
        <x-slot name="heading">
            {{ __('filament-panels::pages/auth/register.heading') }}
        </x-slot>
    @endif

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::auth.register.form.before') }}

    <x-filament-panels::form wire:submit="register">
        {{ $this->form }}

        <x-filament-panels::form.actions :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()" />
    </x-filament-panels::form>

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::auth.register.form.after') }}

    {{-- Login Link --}}
    @if (filament()->hasLogin())
        <div class="mt-6 text-center">
            <span class="text-sm text-gray-600">Sudah punya akun?</span>
            <a href="{{ filament()->getLoginUrl() }}"
                class="text-sm text-primary-600 hover:text-primary-700 font-medium ml-1">
                Login Sekarang!
            </a>
        </div>
    @endif
</x-filament-panels::page.simple>