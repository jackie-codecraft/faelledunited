<?php

namespace App\Providers\Filament;

use App\Filament\Pages\EditProfile;
use App\Http\Middleware\SetAdminLocale;
use Illuminate\Support\HtmlString;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
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

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->profile(EditProfile::class)
            ->brandName('Fælled United')
            ->brandLogo(fn () => new HtmlString(
                '<div style="display:flex;align-items:center;gap:0.65rem;min-width:0">'
                . '<img src="' . asset('images/logo.jpg') . '" '
                . 'style="width:34px;height:34px;border-radius:50%;object-fit:cover;border:2px solid rgba(255,255,255,0.2);flex-shrink:0" '
                . 'alt="Fælled United">'
                . '<span x-show="$store.sidebar.isOpen" x-transition.opacity '
                . 'style="font-size:1.15rem;font-weight:700;color:#fff;letter-spacing:0.04em;line-height:1;white-space:nowrap;overflow:hidden">'
                . 'Fælled United'
                . '</span>'
                . '</div>'
            ))
            ->brandLogoHeight('2.25rem')
            ->renderHook(
                'panels::sidebar.nav.start',
                fn () => new HtmlString(
                    '<div x-cloak x-show="! $store.sidebar.isOpen" '
                    . 'style="display:flex;justify-content:center;padding-bottom:1rem;margin-top:-1rem">'
                    . '<img src="' . asset('images/logo.jpg') . '" '
                    . 'style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid rgba(255,255,255,0.2)" '
                    . 'alt="Fælled United">'
                    . '</div>'
                )
            )

            // ── Theme ───────────────────────────────────────────────────
            ->colors([
                'primary'   => Color::hex('#1a472a'),  // club green
                'gray'      => Color::Zinc,
            ])
            ->darkMode(true)
            ->theme(asset('css/filament/admin/theme.css'))

            // ── Sidebar ─────────────────────────────────────────────────
            ->sidebarCollapsibleOnDesktop()

            // ── Navigation groups (ordered) ──────────────────────────────
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Club')
                    ->icon('heroicon-o-building-office-2'),

                NavigationGroup::make()
                    ->label('News')
                    ->icon('heroicon-o-newspaper'),

                NavigationGroup::make()
                    ->label('Members')
                    ->icon('heroicon-o-users'),

                NavigationGroup::make()
                    ->label('Communications')
                    ->icon('heroicon-o-chat-bubble-left-right'),
            ])

            // ── Resources / pages / widgets ──────────────────────────────
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
                SetAdminLocale::class,
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
            ]);
    }
}
