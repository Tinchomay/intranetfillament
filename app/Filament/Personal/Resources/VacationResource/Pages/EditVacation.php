<?php

namespace App\Filament\Personal\Resources\VacationResource\Pages;

use App\Filament\Personal\Resources\VacationResource;
use App\Mail\VacacionAprobada;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

class EditVacation extends EditRecord
{
    protected static string $resource = VacationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
