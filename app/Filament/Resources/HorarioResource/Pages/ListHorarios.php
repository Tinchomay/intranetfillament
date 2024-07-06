<?php

namespace App\Filament\Resources\HorarioResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\HorarioResource;
use App\Imports\HorariosImport;
use EightyNine\ExcelImport\ExcelImportAction;

class ListHorarios extends ListRecords
{
    protected static string $resource = HorarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExcelImportAction::make()
                ->color("primary")
                ->use(HorariosImport::class),
        ];
    }
}
