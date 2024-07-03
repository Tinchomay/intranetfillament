<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Vacation;
use Filament\Forms\Form;
use App\Models\Calendario;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\VacationResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VacationResource\RelationManagers;

class VacationResource extends Resource
{
    protected static ?string $model = Vacation::class;

    protected static ?string $navigationIcon = 'heroicon-o-sun';

    protected static ?string $navigationLabel = 'Vacaciones';

    protected static ?string $navigationGroup = 'Administrar Empleados';

    protected static ?int $navigationSort = 2;

    protected static ?string $pluralLabel = 'Vacaciones';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('calendario_id')
                    ->required()
                    ->label('Calendario')
                    ->relationship(name: 'calendario', titleAttribute: 'nombre')
                    ->preload()
                    ->searchable()
                    ->live(),
                Forms\Components\Select::make('user_id')
                    ->required()
                    ->relationship(name: 'user', titleAttribute: 'name')
                    ->preload()
                    ->searchable()
                    ->label('Usuario'),
                Forms\Components\DatePicker::make('dia')
                    ->required(),
                Forms\Components\Select::make('type')
                    ->label('Estatus')
                    ->options([
                        'declinado' => 'Declinado',
                        'aprobado' => 'Aprobado',
                        'pendiente' => 'Pendiente'
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('calendario.nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->label('Usuario'),
                Tables\Columns\TextColumn::make('dia')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        //Del lado izquierdo van las opciones y del derecho los estilos
                        'pendiente' => 'warning',
                        'aprobado' => 'success',
                        'declinado' => 'danger'
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'declinado' => 'Declinado',
                        'aprobado' => 'Aprobado',
                        'pendiente' => 'Pendiente'
                    ])
                    ->label('Estatus')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListVacations::route('/'),
            'create' => Pages\CreateVacation::route('/create'),
            'edit' => Pages\EditVacation::route('/{record}/edit'),
        ];
    }
}
