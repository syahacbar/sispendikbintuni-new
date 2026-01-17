<x-filament-panels::page.simple>
    <x-slot name="heading">
        {{ __('filament-panels::pages/auth/password-reset/request-password-reset.heading') }}
    </x-slot>

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::auth.password-reset.request-password-reset.form.before') }}

    <x-filament-panels::form wire:submit="request">
        {{ $this->form }}

        <x-filament-panels::form.actions :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()" />
    </x-filament-panels::form>

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::auth.password-reset.request-password-reset.form.after') }}

    {{-- Back to Login Link --}}
    @if (filament()->hasLogin())
        <div class="mt-6 text-center">
            <a href="{{ filament()->getLoginUrl() }}"
                class="text-sm text-primary-600 hover:text-primary-700 font-medium inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke halaman Login
            </a>
        </div>
    @endif
</x-filament-panels::page.simple>