<?php

namespace App\Filament\Resources\HighUsageMetricResource\Pages;

use App\Filament\Resources\HighUsageMetricResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords; 
 
use App\Filament\Resources\RamUsageChartResource\Widgets\RamUsageChart;
use App\Filament\Resources\CpuUsageChartResource\Widgets\CpuUsageChart;
 


class ListHighUsageMetrics extends ListRecords
{
    protected static string $resource = HighUsageMetricResource::class;

    protected function getActions(): array
    {
        return [
           // Actions\CreateAction::make(),
        ];
    }
    public function getHeaderWidgets(): array
{
    return [
        CpuUsageChart::class,
        RamUsageChart::class,
    ];
}
}
