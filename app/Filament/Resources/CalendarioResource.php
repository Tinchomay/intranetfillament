<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CalendarioResource\Pages;
use App\Filament\Resources\CalendarioResource\RelationManagers;
use App\Models\Calendario;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CalendarioResource extends Resource
{
    protected static ?string $model = Calendario::class;

    protected static ?string $navigationGroup = "Gestión del Sistema";

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('anio')
                    ->required()
                    ->numeric()
                    ->label("Año"),
                Forms\Components\Toggle::make('activo')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('anio')
                    ->numeric()
                    ->sortable()
                    ->label("Año"),
                Tables\Columns\IconColumn::make('activo')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListCalendarios::route('/'),
            'create' => Pages\CreateCalendario::route('/create'),
            'edit' => Pages\EditCalendario::route('/{record}/edit'),
        ];
    }
}
