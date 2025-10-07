<?php

namespace App\Filament\Resources\HardwareResource\Pages;

use App\Filament\Resources\HardwareResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Pages\Actions;

class EditHardware extends EditRecord
{
    protected static string $resource = HardwareResource::class;
    protected function getActions(): array
    {
        return [
           // Actions\DeleteAction::make(),
           // Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
