<?php

namespace App\Filament\Resources\InfraResource\Pages;

use App\Filament\Resources\InfraResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;

#class ListInfra extends ListRecords
class ListInfras extends ListRecords
{
    protected static string $resource = InfraResource::class;
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
