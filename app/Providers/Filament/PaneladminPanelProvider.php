<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PaneladminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('paneladmin')
            ->path('paneladmin')
            // ->brandLogo(fn() => asset('assets/logo-bintuni.png'))
            ->brandName('Sispendik Bintuni')
            ->login()
            ->font('Segoe UI')
            ->colors([
                'primary' => Color::hex('#0093dd'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])

            ->renderHook('panels::body.end', function () {
                return <<<'HTML'
                    <style>
                        .fi-topbar nav {
                            background-color: #0093dd;
                        }

                        nav.fi-sidebar-nav,
                        header.fi-sidebar-header {
                            background-color: #32404d;
                        }

                        .fi-sidebar-nav-groups li.fi-sidebar-item a:hover {
                            background-color: #374a5b !important;
                        }

                        .fi-sidebar-nav-groups li.fi-sidebar-item a span {
                            color: #fff !important;
                            font-weight: normal;
                        }

                        li.fi-sidebar-item.fi-active.fi-sidebar-item-active a:hover {
                            background-color: transparent !important;
                        }

                        li.fi-sidebar-item.fi-active.fi-sidebar-item-active a {
                            background-color: #0093dd;
                        }

                        li.fi-sidebar-item.fi-active.fi-sidebar-item-active a svg,
                        li.fi-sidebar-item.fi-active.fi-sidebar-item-active a span {
                            color: #fff !important;
                        }

                        .fi-logo {
                            color: #fff;
                            max-width: 100% !important;
                            text-align: center;
                            width: 100%;
                            display: flex;
                            justify-content: center;
                        }

                        .fi-main {
                            min-width: 100rem important;
                        }

                        .max-w-7xl {
                            max-width: 100%;
                        }

                        .language-switch-trigger {
                            color: #fff;
                        }

                        .fi-ta-text {
                            padding: 0.45rem !important;
                        }
                    </style>
                HTML;
            });
    }
}
