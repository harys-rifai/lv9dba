<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UatmetricResource\Pages;
use App\Models\Uatmetric;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
class UatmetricResource extends Resource
{
    protected static ?string $model = Uatmetric::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Monitoring';
    protected static ?string $label = 'My Server';
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\DateTimePicker::make('timestamp'),
            Forms\Components\TextInput::make('Hostname')->required(),
            Forms\Components\TextInput::make('IP_Address')->required(),
            Forms\Components\TextInput::make('Database')->required(),
            Forms\Components\TextInput::make('CPU')->required(),
            Forms\Components\TextInput::make('Memory')->required(),
            Forms\Components\TextInput::make('DiskVolGroupAvg')->numeric()->required(),
            Forms\Components\TextInput::make('DiskDataAvg')->numeric()->required(),
            Forms\Components\TextInput::make('ServerStatus')->required(),
            Forms\Components\TextInput::make('LongQueryCount')->numeric()->required(),
            Forms\Components\TextInput::make('idleinQ')->numeric()->required(),
            Forms\Components\TextInput::make('LockingCount')->numeric()->required(),
            Forms\Components\TextInput::make('PostgresVersion')->required(),
            Forms\Components\TextInput::make('flag'),
            Forms\Components\TextInput::make('state'),
            Forms\Components\Hidden::make('created_by')
                ->default(fn () => auth()->id()),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('timestamp')->size('sm')->sortable()->searchable()->label('Date Time'),
                Tables\Columns\TextColumn::make('Hostname')->size('sm')->searchable()->sortable()->color('success'),
                Tables\Columns\TextColumn::make('IP_Address')->size('sm')->searchable()->sortable()->color('success')->label('IP ADRS'),
                Tables\Columns\TextColumn::make('Database')->size('sm')->searchable()->sortable()->color('success'),
                Tables\Columns\TextColumn::make('CPU')->size('sm')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('Memory')->size('sm')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('DiskVolGroupAvg')->size('sm')->sortable()->searchable()->label('disk1'),
                Tables\Columns\TextColumn::make('DiskDataAvg')->size('sm')->sortable()->searchable()->label('disk'),
                Tables\Columns\TextColumn::make('ServerStatus')->size('sm')->sortable()->searchable()->label('status'),
                Tables\Columns\TextColumn::make('LongQueryCount')->size('sm')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('idleinQ')->size('sm')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('LockingCount')->size('sm')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('PostgresVersion')->size('sm')->sortable()->searchable()->label('PGV')->color('success'),
            ])
            ->defaultSort('timestamp', 'desc') // Urutkan berdasarkan waktu terbaru
            ->poll('60s') // Auto-refresh setiap 60 detik
            ->filters([
                SelectFilter::make('ServerStatus')
                    ->options([
                        'accepting' => 'accepting',
                        'Stopped' => 'Stopped',
                        'Maintenance' => 'Maintenance',
                    ])
                    ->label('Status Server'),

                SelectFilter::make('PostgresVersion')
                    ->options(fn () => Uatmetric::query()
                        ->distinct()
                        ->pluck('PostgresVersion', 'PostgresVersion')
                        ->toArray())
                    ->label('Postgres Version'),

                Filter::make('timestamp')
                    ->form([
                        DatePicker::make('from')->label('Dari'),
                        DatePicker::make('until')->label('Sampai'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q) => $q->whereDate('timestamp', '>=', $data['from']))
                            ->when($data['until'], fn ($q) => $q->whereDate('timestamp', '<=', $data['until']));
                    })
                    ->label('Rentang Waktu'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUatmetrics::route('/'),
        ];
    }
}
