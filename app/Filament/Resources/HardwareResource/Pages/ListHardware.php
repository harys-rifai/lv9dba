<?php

namespace App\Filament\Resources\HardwareResource\Pages;

use App\Filament\Resources\HardwareResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;

class ListHardware extends ListRecords
{
    protected static string $resource = HardwareResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalHeading('Add New Hardware')
                ->modalWidth('2xl')
                ->slideOver(),
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

            DeleteAction::make(),
            RestoreAction::make(),
            ForceDeleteAction::make(),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            TrashedFilter::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->withTrashed(); // Menyertakan data yang sudah di-soft delete
    }
}