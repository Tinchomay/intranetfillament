<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\City;
use App\Models\User;
use Filament\Tables;
use App\Models\State;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
//Componente que nos permite crear secciones en el form
use Illuminate\Support\Collection;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    //Aqui Podemos cambiar el titulo de los submenus
    protected static ?string $navigationLabel = "Empleados";

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = "Administrar Empleados";

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //Se crea la seccion y dentro de schema van todos los inputs que seran parte de el
                Section::make('Información Personal')
                //Podemos acomodar esto en columnas
                ->columns(3)
                ->schema([
                    Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nombre'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    //Con esto ocultamos el password al editar para que no lo pida
                    ->hiddenOn('edit')
                    ->maxLength(255)
                ]),
                Section::make('Información de Dirección')
                ->columns(3)
                ->schema([
                    Forms\Components\Select::make('country_id')
                    ->required()
                    //Establecemos la relacion con el modelo country y que nos muestre la columna llamada name
                    ->relationship(name: "country", titleAttribute: "name")
                    ->searchable()
                    //Para que se cargue cuando carga el formulario
                    ->preload()
                    //Para actualizar los resultados mientras el usuario busca
                    ->live()
                    //Con esta funcion establemcemos que cuando eliminamos un padre se eliminen los hijos
                    ->afterStateUpdated(function (Set $set) {
                        $set('state_id',null);
                        $set('city_id',null);
                    } )
                    ->label('Pais'),
                    Forms\Components\Select::make('state_id')
                    ->required()
                    //Buscara los estados segun el country_id
                    ->options(fn (Get $get): Collection => State::query()->where('country_id', $get('country_id'))->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('city_id',null);
                    } )
                    ->label('Estado'),
                    Forms\Components\Select::make('city_id')
                    ->required()
                    //Buscara las ciudades segun el country_id
                    ->options(fn (Get $get): Collection => City::query()->where('state_id', $get('state_id'))->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->label('Ciudad'),
                    Forms\Components\TextInput::make('address')
                    ->required()
                    ->label('Dirección'),
                    Forms\Components\TextInput::make('postal_code')
                    ->required()
                    ->label('Codigo Postal'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state.name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->label('Estado'),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('postal_code')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('created_at')
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
