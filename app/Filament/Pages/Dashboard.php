<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\StatsOverview; 
//use App\Filament\Widgets\UatmetricChart;
//use App\Filament\Widgets\CpuMemoryChart;

class Dashboard extends BaseDashboard
{
    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
            //UatmetricChart::class,
            
        ];
    }
}
