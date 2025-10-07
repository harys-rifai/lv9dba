<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HighUsageMetricResource\Pages;
use App\Models\SystemMetric;
use App\Models\FilteredMetric;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class HighUsageMetricResource extends Resource
{
    protected static ?string $model = SystemMetric::class;
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationLabel = 'High Usage Metrics';
    protected static ?string $navigationGroup = 'Monitoring';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('timestamp')
                    ->sortable()
                    ->size('sm')
                    ->label('Timestamp')
                    ->color('gray'),

                TextColumn::make('hostname')
                    ->label('Host')
                    ->size('sm')
                    ->searchable()
                    ->color('success'),

                
TextColumn::make('environment')
    ->label('Environment')
    ->formatStateUsing(function ($state) {
        $color = \App\Models\FilteredMetric::getEnvironmentColor($state ?? 'unknown');
        return "<span style='
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: {$color};
            margin-right: 6px;
        '></span>" . strtoupper($state);
    })
    ->html()
    ->size('sm')
    ->searchable(),


                BadgeColumn::make('cpu_usage')
                    ->label('CPU Usage')
                    ->size('sm')
                    ->colors([
                        'danger' => fn ($state) => floatval(str_replace('%', '', $state)) > 90,
                        'warning' => fn ($state) => floatval(str_replace('%', '', $state)) > 75,
                        'success' => fn ($state) => floatval(str_replace('%', '', $state)) <= 75,
                    ]),

                BadgeColumn::make('memory_usage')
                    ->label('Memory Usage')
                    ->size('sm')
                    ->colors([
                        'danger' => fn ($state) => preg_match('/\((.*?)%\)/', $state, $m) && floatval($m[1]) > 90,
                        'warning' => fn ($state) => preg_match('/\((.*?)%\)/', $state, $m) && floatval($m[1]) > 75,
                        'success' => fn ($state) => preg_match('/\((.*?)%\)/', $state, $m) && floatval($m[1]) <= 75,
                    ]),

                TextColumn::make('status')
                    ->label('Status')
                    ->icon(fn ($record) => match (strtolower($record->status)) {
                        'accepting' => 'heroicon-o-check-circle',
                        'recovery' => 'heroicon-o-arrow-path',
                        'down', 'fail' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->color(fn ($record) => match (strtolower($record->status)) {
                        'accepting' => 'success',
                        'recovery' => 'warning',
                        'down', 'fail' => 'danger',
                        default => 'gray',
                    })
                    ->size('sm')
                    ->disableClick(),
            ])
            ->filters([
                Filter::make('Threshold')
                    ->form([
                        TextInput::make('cpu')->label('CPU Threshold')->numeric(),
                        TextInput::make('ram')->label('RAM Threshold')->numeric(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['cpu'], fn ($q) => $q->whereRaw("
                                CASE 
                                    WHEN cpu_usage ~ '^[0-9]+(\\.[0-9]+)?%' 
                                    THEN CAST(REPLACE(cpu_usage, '%', '') AS FLOAT) 
                                    ELSE 0 
                                END > {$data['cpu']}
                            "))
                            ->when($data['ram'], fn ($q) => $q->orWhereRaw("
                                CASE 
                                    WHEN memory_usage ~ '\\([0-9]+(\\.[0-9]+)?%\\)' 
                                    THEN CAST(REGEXP_REPLACE(memory_usage, '^.*\\((\\d+(\\.\\d+)?)%\\).*\$', '\\1') AS FLOAT) 
                                    ELSE 0 
                                END > {$data['ram']}
                            "));
                    }),
            ])
            ->actions([
                Action::make('Transfer')
                    ->label('Save to Analytic')
                    ->size('sm')
                    ->color('success')
                    ->icon('heroicon-o-download')
                    ->button()
                    ->tooltip('Klik untuk menyimpan data ke database analitik')
                    ->requiresConfirmation()
                    ->action(function (SystemMetric $record) {
                        $cpu = floatval(str_replace('%', '', $record->cpu_usage));
                        $ram = null;
                        if (preg_match('/\((.*?)%\)/', $record->memory_usage, $matches)) {
                            $ram = floatval($matches[1]);
                        }

                        if ($cpu > 75 || ($ram !== null && $ram > 75)) {
                            DB::connection('pgsql')->table('filtered_metrics')->insert([
                                'timestamp' => $record->timestamp,
                                'hostname' => $record->hostname,
                                'environment' => $record->environment,
                                'cpu_usage' => $cpu,
                                'memory_usage' => $ram,
                                'status' => $record->status,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);

                            Notification::make()
                                ->title('✅ Data berhasil disimpan ke Database Analitik')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('⚠️ Data tidak memenuhi threshold untuk disimpan')
                                ->warning()
                                ->send();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->orderByDesc('timestamp')
            ->where(function ($q) {
                $q->whereRaw("
                    CASE 
                        WHEN cpu_usage ~ '^[0-9]+(\\.[0-9]+)?%' 
                        THEN CAST(REPLACE(cpu_usage, '%', '') AS FLOAT) 
                        ELSE 0 
                    END > 75
                ")
                ->orWhereRaw("
                    CASE 
                        WHEN memory_usage ~ '\\([0-9]+(\\.[0-9]+)?%\\)' 
                        THEN CAST(REGEXP_REPLACE(memory_usage, '^.*\\((\\d+(\\.\\d+)?)%\\).*\$', '\\1') AS FLOAT) 
                        ELSE 0 
                    END > 75
                ");
            });
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHighUsageMetrics::route('/'),
        ];
    }
}