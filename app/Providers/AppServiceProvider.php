<?php


namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\SysSetting;
use Illuminate\Support\ServiceProvider;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;

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
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['id']);
        });

        View::composer('*', function ($view) {
            $pengaturan = SysSetting::getAllAsArray();
            $view->with('pengaturan', $pengaturan);
        });
    }
}
