<x-filament-panels::page.simple>
    @if (filament()->hasLogin())
        <x-slot name="heading">
            {{ __('filament-panels::pages/auth/login.heading') }}
        </x-slot>
    @endif

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::auth.login.form.before') }}

    {{-- Debug: Cek nilai loginError --}}
    @if ($loginError)
        <div
            style="margin-bottom: 1rem; padding: 1rem; border-radius: 0.5rem; background-color: #f8d7da; border: 1px solid #f5c6cb;">
            <div style="display: flex; align-items: flex-start; gap: 0.75rem;">
                <svg style="width: 1.25rem; height: 1.25rem; color: #721c24; flex-shrink: 0; margin-top: 0.125rem;"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <div style="flex: 1;">
                    <p style="font-size: 0.875rem; font-weight: normal; color: #721c24; margin: 0;">
                        {{ $loginError }}
                    </p>
                </div>
            </div>
        </div>
    @else
        {{-- Debug: Alert tidak muncul karena loginError kosong --}}
        <!-- loginError is empty -->
    @endif

    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()" />
    </x-filament-panels::form>

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::auth.login.form.after') }}

    @if ($this->isGoogleLoginEnabled() && $this->hasGoogleCredentials())
        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Atau</span>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('auth.google') }}"
                    class="w-full inline-flex justify-center items-center gap-3 py-3 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                            fill="#4285F4" />
                        <path
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                            fill="#34A853" />
                        <path
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                            fill="#FBBC05" />
                        <path
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                            fill="#EA4335" />
                    </svg>
                    <span>Login dengan Google</span>
                </a>
            </div>
        </div>
    @endif

    {{-- Registration Link --}}
    @if (filament()->hasRegistration())
        <div class="mt-6 text-center">
            <span class="text-sm text-gray-600">Belum punya Akun?</span>
            <a href="{{ filament()->getRegistrationUrl() }}"
                class="text-sm text-primary-600 hover:text-primary-700 font-medium ml-1">
                Registrasi Sekarang!
            </a>
        </div>
    @endif

    {{-- Back to Homepage Link --}}
    <div class="mt-4 text-center">
        <a href="{{ url('/') }}"
            class="text-sm text-gray-600 hover:text-gray-800 transition-colors inline-flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali ke Beranda</span>
        </a>
    </div>
</x-filament-panels::page.simple>