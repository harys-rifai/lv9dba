<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            // Add any widgets you want to display on the view page
        ];
    }

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
           // Actions\DeleteAction::make(),
        ];
    }
}
