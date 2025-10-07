<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SoftwareResource\Pages;
use App\Models\Software;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;

class SoftwareResource extends Resource
{
    protected static ?string $model = Software::class;
    protected static ?string $navigationGroup = 'Tables';
    protected static ?string $label = 'Software';
    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('provaider_id')
                ->label('Provider')
                ->relationship('provaider', 'name')
                ->searchable()
                ->required()
                ->hint('Vendor atau penyedia software'),

            Forms\Components\TextInput::make('name')
                ->label('Software Name')
                ->required()
                ->maxLength(255)
                ->prefixIcon('heroicon-o-chip')
                ->helperText('Nama software sesuai lisensi'),

            Forms\Components\TextInput::make('type')
                ->label('Type')
                ->required()
                ->maxLength(255)
                ->prefixIcon('heroicon-o-chip')
                ->helperText('Jenis software, misalnya: Database, Monitoring, Security'),

            Forms\Components\TextInput::make('licenses')
                ->label('License Count')
                ->numeric()
                ->prefixIcon('heroicon-o-key')
                ->helperText('Jumlah lisensi yang tersedia'),

            Forms\Components\TextInput::make('license_period')
                ->label('License Period')
                ->prefixIcon('heroicon-o-calendar')
                ->helperText('Contoh: 1 Year, 3 Years'),

            Forms\Components\DateTimePicker::make('purchased_at')
                ->label('Purchase Date')
                ->required()
                ->helperText('Tanggal pembelian software'),

            Forms\Components\DateTimePicker::make('expired_at')
                ->label('Expiration Date')
                ->after('purchased_at')
                ->helperText('Tanggal berakhirnya lisensi'),

            Textarea::make('status')
                ->label('Status / Notes')
                ->required()
                ->rows(6)
                ->placeholder('Contoh: aktif, digunakan untuk server X...')
                ->helperText('Catatan status software'),

            Forms\Components\Toggle::make('current')
                ->label('Currently Used')
                ->onColor('success')
                ->offColor('danger')
                ->onIcon('heroicon-o-check')
                ->offIcon('heroicon-o-x')
                ->default(true)
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('provaider.name')->label('Provider')->size('sm')->searchable()->disableClick(),
                BadgeColumn::make('name')->label('Software')->color('success')->size('sm')->searchable()->disableClick(),
                TextColumn::make('type')->label('Type')->size('sm')->searchable()->disableClick(),
                TextColumn::make('licenses')->label('Licenses')->size('sm')->searchable()->disableClick(),
                TextColumn::make('license_period')->label('Period')->size('sm')->disableClick(),
                TextColumn::make('status')->label('Status')->size('sm')->tooltip(fn($record) => \Str::limit($record->status, 50))->searchable()->disableClick(),
                TextColumn::make('purchased_at')->label('Purchased')->size('sm')->dateTime('d M Y')->disableClick(),
                TextColumn::make('expired_at')->label('Expires')->size('sm')->dateTime('d M Y')->disableClick(),
                IconColumn::make('current')->label('Active')->boolean()->trueIcon('heroicon-o-check-circle')->falseIcon('heroicon-o-x-circle')->colors(['true' => 'success', 'false' => 'danger'])->size('sm')->disableClick(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('provaider_id')->relationship('provaider', 'name')->label('Provider'),
                Tables\Filters\SelectFilter::make('type')->label('Type')->options(Software::query()->distinct()->pluck('type', 'type')->toArray()),
                Tables\Filters\SelectFilter::make('current')->label('Currently Used')->options([true => 'Yes', false => 'No']),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

                Action::make('Quick Edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil')
                    ->modalHeading('Edit Informasi Software')
                    ->color('success')
                    ->form([
                        Section::make('Informasi Umum')
                            ->description('Detail utama software')
                            ->schema([
                                Grid::make(2)->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->label('Software Name')
                                        ->required()
                                        ->prefixIcon('heroicon-o-chip')
                                        ->placeholder('Contoh: PostgreSQL')
                                        ->default(fn($record) => $record->name),

                                    Forms\Components\TextInput::make('type')
                                        ->label('Type')
                                        ->required()
                                        ->prefixIcon('heroicon-o-cube')
                                        ->placeholder('Contoh: Database')
                                        ->default(fn($record) => $record->type),
                                ]),

                                Grid::make(2)->schema([
                                    Forms\Components\TextInput::make('licenses')
                                        ->label('License Count')
                                        ->numeric()
                                        ->prefixIcon('heroicon-o-key')
                                        ->default(fn($record) => $record->licenses),

                                    Forms\Components\TextInput::make('license_period')
                                        ->label('License Period')
                                        ->prefixIcon('heroicon-o-calendar')
                                        ->placeholder('Contoh: 1 Year')
                                        ->default(fn($record) => $record->license_period),
                                ]),
                            ]),

                        Section::make('Tanggal & Status')
                            ->description('Informasi pembelian dan status penggunaan')
                            ->schema([
                                Grid::make(2)->schema([
                                    Forms\Components\DateTimePicker::make('purchased_at')
                                        ->label('Purchase Date')
                                        ->required()
                                        ->default(fn($record) => $record->purchased_at),

                                    Forms\Components\DateTimePicker::make('expired_at')
                                        ->label('Expiration Date')
                                        ->default(fn($record) => $record->expired_at),
                                ]),

                                Forms\Components\Textarea::make('status')
                                    ->label('Status / Notes')
                                    ->rows(3)
                                    ->placeholder('Contoh: aktif, digunakan untuk server X...')
                                    ->default(fn($record) => $record->status),

                                Forms\Components\Toggle::make('current')
                                    ->label('Currently Used')
                                    ->onColor('success')
                                    ->offColor('danger')
                                    ->default(fn($record) => $record->current),
                            ]),
                    ])
                    ->action(function (array $data, $record): void {
                        $record->update($data);

                        Notification::make()
                            ->title('Software berhasil diperbarui')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\RestoreBulkAction::make(),
                \pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSoftware::route('/'),
            'create' => Pages\CreateSoftware::route('/create'),
            'edit' => Pages\EditSoftware::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}