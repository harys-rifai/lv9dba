<?php

namespace App\Filament\Resources\HighUsageMetricResource\Pages;

use App\Filament\Resources\HighUsageMetricResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHighUsageMetric extends EditRecord
{
    protected static string $resource = HighUsageMetricResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
