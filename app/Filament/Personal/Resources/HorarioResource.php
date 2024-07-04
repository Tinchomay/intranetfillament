<?php

namespace App\Filament\Personal\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Horario;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Personal\Resources\HorarioResource\Pages;
use App\Filament\Personal\Resources\HorarioResource\RelationManagers;
use Illuminate\Support\Facades\Auth;

class HorarioResource extends Resource
{
    protected static ?string $model = Horario::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?int $navigationSort = 3;

    public static function getEloquentQuery(): Builder
    {
        //Retornamos descendentemente los resultados para mostrar los ultimos
        return parent::getEloquentQuery()->where('user_id', Auth::user()->id)->orderBy('id', 'DESC');
    }

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('calendario_id')
                ->required()
                //Aqui vamos a decir que relacion es, y la columna que queremos mostrar
                ->relationship(name: 'calendario', titleAttribute: 'nombre')
                ->searchable()
                ->live()
                ->preload()
                ->label('Calenadario'),
            Forms\Components\Select::make('type')
                ->options([
                    //El lado izquierdo es el valor que se guardara
                    'trabajo' => 'Trabajo',
                    'pausa' => 'Pausa',
                ])
                ->required()
                ->label('Tipo'),
            Forms\Components\DateTimePicker::make('dia_entrada'),
            Forms\Components\DateTimePicker::make('dia_salida'),
        ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('calendario.nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('dia_entrada')
                    ->dateTime()
                    ->sortable()
                    ->label('Hora inicio'),
                Tables\Columns\TextColumn::make('dia_salida')
                    ->dateTime()
                    ->sortable()
                    ->label('Hora fin'),
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
                SelectFilter::make('type')
                    ->options([
                        'trabajo' => 'Trabajo',
                        'pausa' => 'Pausa'
                    ])
                    ->label('Tipo')
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListHorarios::route('/'),
            'create' => Pages\CreateHorario::route('/create'),
            'edit' => Pages\EditHorario::route('/{record}/edit'),
        ];
    }
}
