<?php

namespace App\Filament\Resources;
use App\Filament\Resources\InfraResource\Pages;
use App\Models\Infra;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\InfraStatus;
use App\Enums\InfraSite;
use App\Enums\InfraManage;
use App\Enums\InfraCate;
use App\Enums\InfraManuf;
use App\Enums\InfraClass;
use App\Enums\InfraActive;
use App\Enums\InfraCategory;
class InfraResource extends Resource
{
    protected static ?string $model = Infra::class;
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Tables';
    protected static ?string $label = 'Sysadmin Server';
    public static function form(Form $form): Form
{
    return $form->schema([
        Section::make('Basic Info')->schema([
            Grid::make(2)->schema([
                Forms\Components\TextInput::make('Hostname')
                    ->label('Hostname')
                    ->required()
                    ->maxLength(50)
                    ->dehydrateStateUsing(fn($state) => strtoupper($state))
                    ->extraAttributes(['oninput' => 'this.value = this.value.toUpperCase()'])
                    ->disabled(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord),

                Forms\Components\TextInput::make('IP_Address')
                    ->label('IP Address')
                    ->required()
                    ->maxLength(50)
                    ->rule('ip')
                    ->disabled(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord),

                Forms\Components\TextInput::make('VM_Name')
                    ->label('VM Name')
                    ->required()
                    ->maxLength(50),

                Forms\Components\TextInput::make('IPBackup')
                    ->label('IP Backup')
                    ->maxLength(25)
                    ->rule('ip'),
            ]),
        ]),

        Section::make('Classification')->schema([
            Grid::make(2)->schema([
                Select::make('Managedby')->label('Managed by')->options(InfraManage::options())->required(),
                Select::make('SiteLocation')->label('Site Location')->options(InfraSite::options())->required(),
                Select::make('Environment')->label('Environment')->options(InfraStatus::options())->required(),
                Select::make('Class_Name')->label('Class Name')->options(InfraClass::options())->required(),
                Select::make('Server_Category')->label('Server Category')->options(InfraCate::options())->required(),
                Select::make('Manufacturer')->label('Manufacturer')->options(InfraManuf::options())->required(),
                Select::make('f26')->label('Status')->options(InfraActive::options())->required(),
                Forms\Components\DateTimePicker::make('updated_at')->label('Last Updated')->disabled(),
            ]),
        ]),

        Section::make('Hardware & OS')->schema([
            Grid::make(2)->schema([
                Forms\Components\TextInput::make('Model')->required()->maxLength(50),
                Forms\Components\TextInput::make('Serial_Number')->label('SN')->maxLength(50),
                Forms\Components\TextInput::make('OS_Update')->label('OS Update')->required()->maxLength(50),
                Forms\Components\TextInput::make('CPU')->numeric()->minValue(1),
                Forms\Components\TextInput::make('Memory_gb')->label('Memory')->numeric()->minValue(1),
                Forms\Components\TextInput::make('Disk_mb')->label('Disk')->numeric()->minValue(1),
            ]),
        ]),

        Section::make('Ownership & Notes')->schema([
            Grid::make(2)->schema([
                Forms\Components\TextInput::make('Server_PIC')->label('Server PIC')->maxLength(50),
                Forms\Components\TextInput::make('Tribe Leader')->label('Tribe LEAD')->maxLength(50),
                Forms\Components\TextInput::make('Tribe')->maxLength(50),
                Forms\Components\TextInput::make('Domain'),
                Forms\Components\TextInput::make('Account'),
                Forms\Components\DateTimePicker::make('Build_Date')->label('Date Build'),
                Forms\Components\Textarea::make('Remark')->label('Remark')->maxLength(250),
                Forms\Components\Textarea::make('Description')->label('Description')->maxLength(150),
            ]),
        ]),
    ]);
}


   public static function table(Table $table): Table
{
    return $table
        ->columns([
            // 🟦 Basic Info
            BadgeColumn::make('Hostname')
                ->label('Hostname')
                ->size('sm')
                ->searchable()
                ->sortable()
                ->color('success')
                ->disableClick(),

            BadgeColumn::make('IP_Address')
                ->label('IP Address')
                ->size('sm')
                ->searchable()
                ->sortable()
                ->color('primary')
                ->disableClick(),

            TextColumn::make('OS_Update')
                ->label('OS')
                ->size('sm')
                ->searchable()
                ->sortable() 
                ->disableClick(),

             
                

                IconColumn::make('Server_Category')
                ->label('Category')
                ->boolean(fn ($record) => $record->Server_Category === 'APP')
                ->trueIcon('heroicon-o-cube')
                ->falseIcon('heroicon-o-database')
                ->colors([
                    'true' => 'success',
                    'false' => 'danger',
                ])
                ->size('sm')
                ->tooltip(fn ($record) => "Category: {$record->Server_Category}")
                ->disableClick()->sortable(),





            // 🟥 Ownership
            TextColumn::make('Server_PIC')
                ->label('SVR PIC')
                ->size('sm')
                ->searchable()
                ->sortable()
                ->color('info')
                ->disableClick(),

            TextColumn::make('TribeLeader')
                ->label('TribeLEAD')
                ->size('sm')
                ->searchable()->sortable()
                ->disableClick(),

            TextColumn::make('Tribe')
                ->size('sm')
                ->searchable()->sortable()
                ->disableClick(),

            TextColumn::make('SiteLocation')
                ->label('Site Location')
                ->size('sm')
                ->searchable()->sortable()
                ->disableClick(),

            TextColumn::make('Environment')
                ->size('sm')
                ->sortable()
                ->color('warning')->sortable()
                ->disableClick(),

            TextColumn::make('updated_at')
                ->label('Update')
                ->size('sm')
                ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->format('d M Y'))
                ->sortable()
                ->disableClick(),
        ])
        ->filters([
            SelectFilter::make('Managedby')
                ->label('Managed by')
                ->options(InfraManage::options())
                ->searchable()
                ->multiple(),

            SelectFilter::make('SiteLocation')
                ->label('Site Location')
                ->options(InfraSite::options())
                ->searchable()
                ->multiple(),

            SelectFilter::make('Environment')
                ->label('Environment')
                ->options(InfraStatus::options())
                ->searchable()
                ->multiple(),

            SelectFilter::make('Server_Category')
                ->label('Category')
                ->options(InfraCate::options())
                ->searchable()
                ->multiple(),
        ])
        ->defaultSort('id', 'desc')
        ->actions([
            Tables\Actions\ViewAction::make(),

            Tables\Actions\EditAction::make()
                ->modalHeading('Edit Server Info')
                ->slideOver()
                ->icon('heroicon-o-pencil')
                ->tooltip('Edit this record'),
        ])
        ->bulkActions([
            \pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction::make(),
        ]);
}


    public static function getRelations(): array
    {
        return [
            // Add RelationManagers here if needed
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInfras::route('/'),
            'create' => Pages\CreateInfra::route('/create'),
            'edit' => Pages\EditInfra::route('/{record}/edit'),
        ];
    }
}