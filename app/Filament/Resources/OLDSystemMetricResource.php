<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SystemMetricResource\Pages;

use App\Models\SystemMetric;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class SystemMetricResource extends Resource
{
    protected static ?string $model = SystemMetric::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Monitoring';
    protected static ?string $label = 'PROD Metric';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\DateTimePicker::make('timestamp')->required(),
            Forms\Components\TextInput::make('hostname')->required(),
            Forms\Components\TextInput::make('environment')->required(),
            Forms\Components\Textarea::make('cpu_usage'),
            Forms\Components\Textarea::make('memory_usage'),
            Forms\Components\Textarea::make('disk_usage'),
            Forms\Components\Textarea::make('network_usage'),
            Forms\Components\TextInput::make('status')->required(),
            Forms\Components\TextInput::make('extra1')->required(),
            Forms\Components\TextInput::make('extra2')->required(),
            Forms\Components\TextInput::make('file_name')->required(),
            Forms\Components\TextInput::make('load_status')->required(),
            Forms\Components\Textarea::make('pgver'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('timestamp')
                    ->color('success')
                    ->size('sm')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('hostname')
                    ->color('success')
                    ->size('sm')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('environment')
                    ->size('sm')
                    ->sortable()
                    ->searchable(),

                IconColumn::make('status')
                    ->label('Status')
                    ->boolean(fn ($state) => $state === 'SUCCESS')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->colors([
                        'true' => 'success',
                        'false' => 'danger',
                    ])
                    ->size('sm')
                    ->disableClick(),

                TextColumn::make('cpu_usage')
                    ->formatStateUsing(fn ($state) => number_format((float)$state, 2) . '%')
                    ->color(fn ($record) => is_numeric($record->cpu_usage) && (float)$record->cpu_usage > 75 ? 'danger' : null)
                    ->size('sm')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('memory_usage')
                    ->formatStateUsing(fn ($state) => number_format((float)$state, 2) . '%')
                    ->color(fn ($record) => is_numeric($record->memory_usage) && (float)$record->memory_usage > 75 ? 'danger' : null)
                    ->size('sm')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('pgver')
                    ->label('PGV')
                    ->size('sm')
                    ->searchable()
                    ->disableClick(),
            ])
            ->defaultSort('timestamp', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                ExportBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSystemMetrics::route('/'),
        ];
    }
}
