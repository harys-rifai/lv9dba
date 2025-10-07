<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeriphelResource\Pages;
use App\Models\Periphel;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PeriphelResource extends Resource
{
    protected static ?string $model = Periphel::class;

    protected static ?string $navigationGroup = 'meta';

    protected static ?string $navigationIcon = 'heroicon-o-camera';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('provaider_id')
                    ->relationship('provaider', 'name')
                    ->required(),
                Forms\Components\TextInput::make('make')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('model')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('serial')
                    ->maxLength(255),
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('current')
                    ->required(),
                Forms\Components\DateTimePicker::make('purchased_at')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->size('sm'),
                Tables\Columns\TextColumn::make('provaider.name')->size('sm'),
                Tables\Columns\TextColumn::make('make')->size('sm'),
                Tables\Columns\TextColumn::make('model')->size('sm'),
                Tables\Columns\TextColumn::make('serial')->size('sm'),
                Tables\Columns\TextColumn::make('type')->size('sm'),
                Tables\Columns\IconColumn::make('current')->size('sm')
                    ->boolean(),
                Tables\Columns\TextColumn::make('purchased_at')->size('sm')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
                \pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeriphels::route('/'),
            'create' => Pages\CreatePeriphel::route('/create'),
            'edit' => Pages\EditPeriphel::route('/{record}/edit'),
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
