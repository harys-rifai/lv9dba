<?php

namespace App\Filament\Resources;
use App\Enums\HardwareStatus;
use App\Enums\HardwareType as EnumsHardwareType;
use App\Filament\Resources\HardwareResource\Pages;
use App\Models\Hardware;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope; 
use Filament\Resources\Pages\CreateRecord;

class HardwareResource extends Resource
{
    protected static ?string $model = Hardware::class;
    protected static ?string $navigationGroup = 'Tables';
    protected static ?string $label = 'DBA Server';
    protected static ?string $navigationIcon = 'heroicon-o-desktop-computer';
    
     
 public static function form(Form $form): Form
{
    return $form->schema([
        Section::make('Basic Info')
            ->schema([
            Grid::make(2)->schema([
                Forms\Components\TextInput::make('serial')
                    ->label('Hostname')
                    ->placeholder('VIDDCLXPAOBDB04')
                    ->helperText('Gunakan format standar hostname server')
                    ->required()
                    ->maxLength(50)
                    ->dehydrateStateUsing(fn($state) => strtoupper($state))
                    ->extraAttributes(['oninput' => 'this.value = this.value.toUpperCase()', 'class' => 'w-64']) // Lebar dikurangi
                    ->disabled(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord),

                Forms\Components\TextInput::make('make')
                    ->label('IP Address')
                    ->placeholder('10.xx.xx.xx')
                    ->helperText('Masukkan IP address yang valid')
                    ->required()
                    ->maxLength(25)
                    ->rule('ip')
                    ->extraAttributes(['class' => 'w-64'])
                    ->disabled(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord),

                Forms\Components\TextInput::make('model')
                    ->label('Model')
                    ->required()
                    ->maxLength(50)
                    ->prefixIcon('heroicon-o-chip')
                    ->extraAttributes(['class' => 'w-64']),

                Select::make('status')
                    ->label('Status')
                    ->options(HardwareStatus::options())
                    ->required()
                    ->hint('Pilih status terkini dari hardware'),

                Select::make('type')
                    ->label('Type of Hardware')
                    ->options(EnumsHardwareType::options())
                    ->required()
                    ->hint('Jenis perangkat keras yang digunakan'),
            ]),
        ]),

        Section::make('System Info')->schema([
            Grid::make(2)->schema([
                Forms\Components\TextInput::make('os_name')
                    ->label('Operating System')
                    ->placeholder('Linux/Windows & Version')
                    ->maxLength(25)
                    ->prefixIcon('heroicon-o-chip')
                    ->extraAttributes(['class' => 'w-64']),

                Forms\Components\TextInput::make('os_version')
                    ->label('Database Name & Version')
                    ->placeholder('Postgres/SqlSvr/Oracle/DB2/Other')
                    ->maxLength(60)
                    ->prefixIcon('heroicon-o-chip')
                    ->extraAttributes(['class' => 'w-64']),

                Forms\Components\TextInput::make('ram')
                    ->label('RAM')
                    ->placeholder('Number without GB')
                    ->numeric()
                    ->minValue(1)
                    ->prefixIcon('heroicon-o-chip')
                    ->suffix('GB')
                    ->extraAttributes(['class' => 'w-40']),

                Forms\Components\TextInput::make('cpu')
                    ->label('CPU')
                    ->maxLength(25)
                    ->prefixIcon('heroicon-o-chip')
                    ->extraAttributes(['class' => 'w-64']),
            ]),
        ]),

        Section::make('Ownership')->schema([
            Grid::make(2)->schema([
                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->hint('User yang bertanggung jawab atas Server'),

                Select::make('provaider_id')
                    ->label('Brand')
                    ->relationship('provaider', 'name')
                    ->required()
                    ->searchable()
                    ->hint('Brand atau vendor Server'),

                Forms\Components\DateTimePicker::make('purchased_at')
                    ->label('Purchase Date')
                    ->required()
                    ->hint('Tanggal pembelian Server'),

                Forms\Components\Toggle::make('current')
                    ->label('Currently Used')
                    ->onColor('success')
                    ->offColor('danger')
                    ->onIcon('heroicon-o-check')
                    ->offIcon('heroicon-o-x')
                    ->default(true)
                    ->required(),
            ]),
        ]),

        Section::make('Notes')->schema([
            Grid::make(1)->schema([
                Textarea::make('note')
                    ->label('Detailed Note')
                    ->rows(4)
                    ->placeholder('Examp:...')
                    ->helperText('Maksimal 500 karakter')
                    ->maxLength(500)
                    ->rules('required|string|max:500'),
            ]),
        ]),
    ]);
}


    public static function table(Table $table): Table
            {
                Column::configureUsing(function (Column $column): void {
                    $column->toggleable()->searchable()->sortable();
                });

                return $table
                    ->columns([
                        Tables\Columns\BadgeColumn::make('serial')
                            ->label('Hostname')
                            ->description(fn($record) => $record->model)
                            ->color('success')
                            ->size('sm')
                            ->searchable()
                            ->disableClick(),

                        Tables\Columns\BadgeColumn::make('make')
                            ->label('IP Address')
                            ->extraAttributes(['class' => 'bg-blue-500 text-white'])
                            ->tooltip(fn($record) => 'IP: ' . $record->model)
                            ->size('sm')
                            ->searchable()
                            ->disableClick(),

                        TextColumn::make('model')
                            ->label('Model')
                            ->size('sm')
                            ->tooltip(fn($record) => $record->make)
                            ->searchable()
                            ->disableClick(),

                        TextColumn::make('os_name')
                            ->label('OS')
                            ->size('sm')
                            ->searchable()
                            ->disableClick(),

                        TextColumn::make('os_version')
                            ->label('DB Vers')
                            ->tooltip(fn($record) => 'Database: ' . $record->os_version)
                            ->size('sm')
                            ->searchable()
                            ->disableClick(),

                        TextColumn::make('ram')
                            ->label('RAM')
                            ->formatStateUsing(fn($state) => $state . ' GB')
                            ->size('sm')
                            ->searchable()
                            ->disableClick(),

                        TextColumn::make('cpu')
                            ->label('CPU')
                            ->size('sm')
                            ->searchable()
                            ->disableClick(),

                        Tables\Columns\IconColumn::make('current')
                            ->label('Active')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->colors([
                                'true' => 'success',
                                'false' => 'danger',
                            ])
                            ->size('sm')
                            ->disableClick(),

                        TextColumn::make('note')
                            ->label('Note')
                            ->size('sm')
                            ->searchable()
                            ->toggleable(isToggledHiddenByDefault: true)
                            ->disableClick(),
                    ])
                    ->filters([
                        Tables\Filters\TrashedFilter::make(),

                        Tables\Filters\SelectFilter::make('status')
                            ->options(HardwareStatus::options())
                            ->label('Status'),

                        Tables\Filters\SelectFilter::make('type')
                            ->options(EnumsHardwareType::options())
                            ->label('Type'),

                        Tables\Filters\SelectFilter::make('user_id')
                            ->relationship('user', 'name')
                            ->label('User'),

                        Tables\Filters\SelectFilter::make('provaider_id')
                            ->relationship('provaider', 'name')
                            ->label('Provider'),
                    ])
                    ->actions([
                        Tables\Actions\EditAction::make(),
                        Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListHardware::route('/'),
            'create' => Pages\CreateHardware::route('/create'),
            'edit' => Pages\EditHardware::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}