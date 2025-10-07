<?php

namespace App\Filament\Resources\HardwareResource\Pages;

use App\Filament\Resources\HardwareResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
class CreateHardware extends CreateRecord
{
    protected static string $resource = HardwareResource::class;
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalHeading('Add New Hardware')
                ->modalWidth('2xl') // Optional: sm, md, lg, xl, 2xl
                ->slideOver(),     // Use modal() if you prefer a centered modal
        ];
    }
    protected function getTableActions(): array
    {
        return [
            ViewAction::make()
                ->modalHeading('View Hardware Details')
                ->modalWidth('2xl')
                ->slideOver(),

            EditAction::make()
                ->modalHeading('Edit Hardware')
                ->modalWidth('2xl')
                ->slideOver(),
        ];
    }
}