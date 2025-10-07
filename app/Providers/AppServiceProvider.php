<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Uatmetric;
use App\Observers\UatmetricObserver;
use App\Models\Infra;
use App\Observers\InfraObserver;
use App\Models\Hardware;
use App\Observers\HardwareObserver;
use Filament\Facades\Filament; // ✅ untuk Filament v2

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Uatmetric::observe(UatmetricObserver::class);
        Infra::observe(InfraObserver::class);
        Hardware::observe(HardwareObserver::class);

        Filament::serving(function () {
            Filament::registerWidgets([
            ]);
        });
    }
}
