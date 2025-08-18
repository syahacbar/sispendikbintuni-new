<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use App\Models\SysSetting;
use Filament\PanelProvider;
use Filament\Enums\ThemeMode;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class PaneladminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('paneladmin')
            ->darkMode(false)
            ->path('paneladmin')
            ->brandName('Sistem Perencanaan Terintegrasi')
            ->login()
            // ->breadcrumbs(false)
            ->font('Segoe UI')
            ->colors([
                'primary' => Color::hex('#0093dd'),
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label('Kunjungi Web')
                    ->url('/')
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-globe-alt'),
            ])
            ->sidebarFullyCollapsibleOnDesktop()
            ->defaultThemeMode(ThemeMode::Light)
            ->favicon(function () {
                $favicon = SysSetting::where('key', 'favicon')->value('value');

                return $favicon
                    ? asset('storage/' . $favicon)
                    : asset('themes/frontend/logoserasi.png');
            })
            ->brandLogo(fn() => view('filament.admin.logo'))
            ->brandLogoHeight('3rem')

            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
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
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ])

            ->navigationGroups([
                'Data Referensi',
                'Data Master',
                'Manajemen Konten Web',
                'Manajemen Pengguna',
                'Pengaturan',
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
                            height: 4rem;
                        }

                        .fi-sidebar-nav-groups li.fi-sidebar-item a:hover {
                            background-color: #374a5b !important;
                        }

                        .fi-sidebar-nav-groups li.fi-sidebar-item span.fi-sidebar-item-label {
                            color: #fff !important;
                            font-weight: normal;
                        }

                        li.fi-sidebar-item.fi-active.fi-sidebar-item-active a:hover {
                            background-color: transparent !important;
                        }

                        li.fi-sidebar-item.fi-active.fi-sidebar-item-active a {
                            background-color: #0093dd;
                        }

                        /* li.fi-sidebar-item.fi-active.fi-sidebar-item-active a span { */
                        li.fi-sidebar-item.fi-active.fi-sidebar-item-active a svg {
                            color: #fff !important;
                        }

                        .fi-logo {
                            color: #fff;
                            max-width: 100% !important;
                            text-align: center;
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

                        .fi-sidebar-nav::-webkit-scrollbar {
                            display: none;
                        }

                        .fi-sidebar-nav {
                            -ms-overflow-style: none;
                            scrollbar-width: none;
                        }

                        .fi-sidebar-nav-groups {
                           gap: 5px !important;
                        }

                        .fi-sidebar-nav {
                            padding-left: 1rem;
                            padding-right: 1rem;
                        }

                        .fi-sidebar-group-label {
                            color: lightblue;
                        }

                        main.fi-main {
                            padding-left: 1.5rem;
                            padding-right: 1.5rem;
                        }

                        .fi-ta-table thead tr {
                            background-color: #0093dd;
                        }
                        .fi-ta-table thead tr span {
                            color: #fff;
                        }

                        .fi-ta-actions span {
                            display: none;
                        }

                       .fi-ta-actions svg {
                            width: 1.3rem;
                            height: 1.3rem
                        }
                        
                        .fi-dropdown-list span {
                            display: inline;
                        }

                        .fi-topbar button svg.fi-icon-btn-icon {
                            color: #fff;
                        }
                    </style>
                HTML;
            });
    }
}
