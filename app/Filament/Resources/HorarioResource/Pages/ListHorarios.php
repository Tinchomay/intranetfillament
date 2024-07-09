<?php

namespace App\Filament\Resources\HorarioResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\HorarioResource;
use App\Imports\HorariosImport;
use EightyNine\ExcelImport\ExcelImportAction;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;

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
            Action::make('crearPDF')
                ->label('Crear PDF')
                ->color('warning')
                ->requiresConfirmation()
                ->url( fn() =>
                    route('pdf.example', ['user' => 3]),
                    shouldOpenInNewTab: false
                ),
        ];
    }
}
