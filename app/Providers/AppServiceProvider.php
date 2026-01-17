<?php


namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\SysSetting;
use Illuminate\Support\ServiceProvider;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;

use Livewire\Livewire;
use Filament\Livewire\DatabaseNotifications;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::component('filament.livewire.database-notifications', DatabaseNotifications::class);
        Livewire::component('app.filament.paneladmin.pages.auth.select-school', \App\Filament\Paneladmin\Pages\Auth\SelectSchool::class);

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['id']);
        });

        View::composer('*', function ($view) {
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('sys_settings')) {
                    $pengaturan = SysSetting::getAllAsArray();
                    $view->with('pengaturan', $pengaturan);
                }
            } catch (\Exception $e) {
                // Silently fail during migration
            }
        });

        // Configure Google OAuth from database settings
        $this->configureGoogleOAuth();
    }

    /**
     * Configure Google OAuth dynamically from database
     */
    protected function configureGoogleOAuth(): void
    {
        try {
            // Check if table exists before querying (prevents migration errors)
            if (!\Illuminate\Support\Facades\Schema::hasTable('sys_settings')) {
                return;
            }

            $clientId = SysSetting::getValue('google_client_id');
            $clientSecret = SysSetting::getValue('google_client_secret');

            if ($clientId && $clientSecret) {
                config([
                    'services.google.client_id' => $clientId,
                    'services.google.client_secret' => $clientSecret,
                    'services.google.redirect' => url('/paneladmin/auth/google/callback'),
                ]);
            }
        } catch (\Exception $e) {
            // Silently fail if database not ready (e.g., during migration)
        }
    }
}
