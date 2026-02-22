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
use App\Filament\Widgets\NewRegistrationsWidget;
use App\Filament\Widgets\OpenInquiriesWidget;
use App\Filament\Widgets\StatsOverviewWidget;
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
            ->brandLogo(function () {
                // Login page — large prominent branding block
                if (request()->routeIs('filament.admin.auth.*')) {
                    return new HtmlString(
                        '<div style="display:flex;flex-direction:column;align-items:center;gap:0.75rem;padding:0.5rem 0 0.25rem">'
                        . '<img src="' . asset('images/logo.jpg') . '" '
                        . 'style="width:96px;height:96px;border-radius:50%;object-fit:cover;border:4px solid #1a472a;box-shadow:0 4px 20px rgba(26,71,42,0.25)" '
                        . 'alt="Fælled United">'
                        . '<div style="text-align:center">'
                        . '<div style="font-family:\'Bebas Neue\',sans-serif;font-size:2rem;color:#0f2718;letter-spacing:0.08em;line-height:1">FÆLLED UNITED</div>'
                        . '<div style="font-size:0.75rem;color:#6b7280;letter-spacing:0.12em;text-transform:uppercase;margin-top:0.2rem">Administration</div>'
                        . '</div>'
                        . '</div>'
                    );
                }
                // Sidebar — compact version
                return new HtmlString(
                    '<div style="display:flex;align-items:center;gap:0.65rem;min-width:0">'
                    . '<img src="' . asset('images/logo.jpg') . '" '
                    . 'style="width:34px;height:34px;border-radius:50%;object-fit:cover;border:2px solid rgba(255,255,255,0.2);flex-shrink:0" '
                    . 'alt="Fælled United">'
                    . '<span x-show="$store.sidebar.isOpen" x-transition.opacity '
                    . 'style="font-size:1.15rem;font-weight:700;color:#fff;letter-spacing:0.04em;line-height:1;white-space:nowrap;overflow:hidden">'
                    . 'Fælled United'
                    . '</span>'
                    . '</div>'
                );
            })
            ->brandLogoHeight('auto')
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
                    ->label(fn () => __('admin.nav_group.club'))
                    ->icon('heroicon-o-building-office-2'),

                NavigationGroup::make()
                    ->label(fn () => __('admin.nav_group.members'))
                    ->icon('heroicon-o-users'),

                NavigationGroup::make()
                    ->label(fn () => __('admin.nav_group.communications'))
                    ->icon('heroicon-o-chat-bubble-left-right'),

                NavigationGroup::make()
                    ->label(fn () => __('admin.nav_group.news'))
                    ->icon('heroicon-o-newspaper'),

                NavigationGroup::make()
                    ->label(fn () => __('admin.nav_group.administration'))
                    ->icon('heroicon-o-cog-6-tooth'),
            ])

            // ── Resources / pages / widgets ──────────────────────────────
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                StatsOverviewWidget::class,
                OpenInquiriesWidget::class,
                NewRegistrationsWidget::class,
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
                SetAdminLocale::class,  // must run after session + auth are established
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
