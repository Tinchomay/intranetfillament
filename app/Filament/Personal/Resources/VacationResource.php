<?php

namespace App\Filament\Personal\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Vacation;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Personal\Resources\VacationResource\Pages;
use App\Filament\Personal\Resources\VacationResource\RelationManagers;

class VacationResource extends Resource
{
    protected static ?string $pluralLabel = 'Vacaciones';

    protected static ?string $model = Vacation::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-sun';

    protected static ?string $navigationLabel = 'Vacaciones';

    //Agregando los numeros
    public static function getNavigationBadge(): ?string
    {
        return parent::getEloquentQuery()->where('user_id', Auth::user()->id)->where('type', 'pendiente')->where('dia', '>', now()->format('Y-m-d'))->count();
    }

    //Cambiando el color segun el numero
    public static function getNavigationBadgeColor(): ?string
    {
        return parent::getEloquentQuery()->where('user_id', Auth::user()->id)->where('type', 'pendiente')->where('dia', '>', now()->format('Y-m-d'))->count() > 0 ? 'danger' : 'primary';
    }
    //Agregando una leyenda si ponen el mouse arriba
    protected static ?string $navigationBadgeTooltip = 'Vacaciones pendientes de autorización';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::user()->id);
    }

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
            Forms\Components\DatePicker::make('dia')
                ->required()
                ->minDate(now()->format('Y-m-d')),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('calendario.nombre')
                    ->searchable(),
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
