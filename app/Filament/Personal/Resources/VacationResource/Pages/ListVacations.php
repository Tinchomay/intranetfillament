<?php

namespace App\Filament\Personal\Resources\VacationResource\Pages;

use App\Filament\Personal\Resources\VacationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVacations extends ListRecords
{
    protected static string $resource = VacationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Crear Vacación'),
        ];
    }
}
