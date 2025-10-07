<?php

namespace App\Filament\Resources\FilteredMetricResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\FilteredMetricResource;

class ListFilteredMetrics extends ListRecords
{
    protected static string $resource = FilteredMetricResource::class;
}