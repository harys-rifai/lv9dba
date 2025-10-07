<?php

use App\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Http\Middleware\MirrorConfigToSubpackages;
use Filament\Pages;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Wallo\FilamentCompanies\Http\Middleware\AuthenticateSession;

return [

  

    'path' => env('FILAMENT_PATH', 'admin'),

   

    'core_path' => env('FILAMENT_CORE_PATH', 'filament'),
 

    'domain' => env('FILAMENT_DOMAIN'),

 
    'home_url' => '/',
 

    'brand' => env('APP_NAME'),

  

    'auth' => [
        'guard' => env('FILAMENT_AUTH_GUARD', 'web'),
        'pages' => [
            'login' => null,
        ],
    ],

   

    'pages' => [
        'namespace' => 'App\\Filament\\Pages',
        'path' => app_path('Filament/Pages'),
        'register' => [
           // Pages\Dashboard::class,
             
        ],
    ],

  

    'resources' => [
        'namespace' => 'App\\Filament\\Resources',
        'path' => app_path('Filament/Resources'),
        'register' => [],
    ],

   

    'widgets' => [
        'namespace' => 'App\\Filament\\Widgets',
        'path' => app_path('Filament/Widgets'),
        'register' => [
            Widgets\AccountWidget::class,
            //App\Filament\Widgets\UatmetricChart::class
            // Widgets\FilamentInfoWidget::class,
        ],
    ],

    

    'livewire' => [
        'namespace' => 'App\\Filament',
        'path' => app_path('Filament'),
    ],

  

    'dark_mode' => true,

    

    'database_notifications' => [
        'enabled' => true,
        'polling_interval' => '30s',
    ],

    

    'broadcasting' => [

       

    ],
 

    'layout' => [
    'actions' => [
        'modal' => [
            'actions' => [
                'alignment' => 'left',
            ],
        ],
    ],
    'forms' => [
        'actions' => [
            'alignment' => 'left',
            'are_sticky' => false,
        ],
        'have_inline_labels' => false,
    ],
    'footer' => [
        'should_show_logo' => false, // Corrected typo from 'tru' to 'true'
    ],
    'max_content_width' => 'full', // Set to full width
    'notifications' => [
        'vertical_alignment' => 'top',
        'alignment' => 'right',
    ],
    'sidebar' => [
        'is_collapsible_on_desktop' => true,
        'groups' => [
            'are_collapsible' => true,
        ],
        'width' => null,
        'collapsed_width' => null,
    ],
],


     

    'favicon' => null,

    

    'default_avatar_provider' => \Filament\AvatarProviders\UiAvatarsProvider::class,

    
    'default_filesystem_disk' => env('FILAMENT_FILESYSTEM_DRIVER', 'public'),

  

    'google_fonts' => 'https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap',

    

    'middleware' => [
        'auth' => [
            Authenticate::class,
            // lockscreen\FilamentLockscreen\Http\Middleware\LockerLocker::class,
        ],
        'base' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            AuthenticateSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
            DispatchServingFilamentEvent::class,
            MirrorConfigToSubpackages::class,
        ],
    ],

];
