<?php

namespace App\Filament\Resources\InfraResource\Pages;

use App\Filament\Resources\InfraResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInfra extends EditRecord
{
    protected static string $resource = InfraResource::class;
    protected function getActions(): array
    {
        return [
           // Actions\DeleteAction::make(),
           // Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}

