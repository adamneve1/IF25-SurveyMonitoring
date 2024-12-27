<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
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
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class OperationalPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('operational')
            ->login()
            ->path('operational')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->darkMode(condition:false)
            ->discoverResources(in: app_path('Filament/Operational/Resources'), for: 'App\\Filament\\Operational\\Resources')
              ->discoverPages(in: app_path('Filament/Operational/Pages'), for: 'App\\Filament\\Operational\\Pages')
            ->pages([])
           ->discoverWidgets(in: app_path('Filament/Operational/Widgets'), for: 'App\\Filament\\Operational\\Widgets')
            ->navigationItems([
                \Filament\Navigation\NavigationItem::make('Absensi')
                ->url('/operational/manpowers')
                ->icon('heroicon-o-user-group'),
             
                    \Filament\Navigation\NavigationItem::make('Overtime (Manhour)')
                        ->url('/operational/manhours')
                        ->icon('heroicon-o-user-plus'),
                      
                   
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
            ]);
    }
}