<?php

namespace App\Providers;

use App\Services\MailConfigService;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(MailConfigService::class, function ($app) {
            return new MailConfigService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Apply mail configuration from database on every request
        // This ensures that mail settings from admin panel are always used
        try {
            $mailConfigService = $this->app->make(MailConfigService::class);

            // Only apply if configuration exists in database
            if ($mailConfigService->hasConfig()) {
                $mailConfigService->applyConfig();
            }
        } catch (\Exception $e) {
            // Silently fail if database is not available (e.g., during migration)
            // This prevents errors during installation or migration
        }
    }
}
