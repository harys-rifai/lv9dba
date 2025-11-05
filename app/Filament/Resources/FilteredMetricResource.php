<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FilteredMetricResource\Pages;
use App\Models\FilteredMetric;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FilteredMetricResource extends Resource
{
    protected static ?string $model = FilteredMetric::class;
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Alert Issue Record';
    protected static ?string $navigationGroup = 'Monitoring';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('timestamp')
                    ->size('sm')
                    ->searchable()
                    ->label('Timestamp')
                    ->color('gray'),

                TextColumn::make('hostname')
                    ->label('Host')
                    ->size('sm')
                    ->searchable()
                    ->color('primary'),

                BadgeColumn::make('environment')
                    ->label('Env')->size('sm')
                    ->searchable()
                    ->colors([
                        'danger' => 'production',
                        'warning' => 'staging',
                        'success' => 'development',
                        'gray' => fn ($state) => !in_array($state, ['production', 'staging', 'development']),
                    ]),

                BadgeColumn::make('cpu_usage')
                    ->label('CPU Usage')->size('sm')
                    ->searchable()
                    ->colors([
                        'danger' => fn ($state) => floatval(str_replace('%', '', $state)) > 90,
                        'warning' => fn ($state) => floatval(str_replace('%', '', $state)) > 75,
                        'success' => fn ($state) => floatval(str_replace('%', '', $state)) <= 75,
                    ]),

                BadgeColumn::make('memory_usage')
                    ->label('Memory Usage')->size('sm')
                    ->searchable()
                    ->colors([
                        'danger' => fn ($state) => preg_match('/\((.*?)%\)/', $state, $m) && floatval($m[1]) > 90,
                        'warning' => fn ($state) => preg_match('/\((.*?)%\)/', $state, $m) && floatval($m[1]) > 75,
                        'success' => fn ($state) => preg_match('/\((.*?)%\)/', $state, $m) && floatval($m[1]) <= 75,
                    ]),

                Tables\Columns\IconColumn::make('status')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->colors([
                        'danger' => 'critical',
                        'warning' => 'fail',
                        'success' => 'accepting',
                        'gray' => fn ($state) => !in_array(strtolower($state), ['down', 'warning', 'issue']),
                    ])
                    ->size('sm')
                    ->disableClick(),

                TextColumn::make('created_at')
                    ->label('Saved At')->size('sm')
                    ->searchable()
                    ->color('gray'),
            ])
            ->defaultSort('timestamp', 'desc')
            ->bulkActions([
                BulkAction::make('exportCsv')
                    ->label('Export to CSV')
                    ->icon('heroicon-o-arrow-down')
                    ->action(function (Collection $records): StreamedResponse {
                        $filename = 'filtered_metrics_' . now()->format('Y-m-d_H-i-s') . '.csv';

                        return response()->streamDownload(function () use ($records) {
                            $handle = fopen('php://output', 'w');

                            // Header CSV
                            fputcsv($handle, ['Timestamp', 'Hostname', 'Environment', 'CPU Usage (%)', 'Memory Usage (%)', 'Status']);

                            // Isi data
                            foreach ($records as $record) {
                                $cpu = floatval(str_replace('%', '', $record->cpu_usage));

                                $ram = null;
                                if (preg_match('/\((.*?)%\)/', $record->memory_usage, $matches)) {
                                    $ram = floatval($matches[1]);
                                }

                                fputcsv($handle, [
                                    $record->timestamp,
                                    $record->hostname,
                                    $record->environment,
                                    $cpu,
                                    $ram,
                                    $record->status,
                                ]);
                            }

                            fclose($handle);
                        }, $filename);
                    })
                    ->deselectRecordsAfterCompletion()
                    ->requiresConfirmation(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->orderByDesc('timestamp');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFilteredMetrics::route('/'),
        ];
    }

    public static function getRelations(): array
    {
        return [];
    }
}