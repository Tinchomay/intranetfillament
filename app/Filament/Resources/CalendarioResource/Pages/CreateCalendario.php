<?php

namespace App\Filament\Resources\CalendarioResource\Pages;

use App\Filament\Resources\CalendarioResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCalendario extends CreateRecord
{
    protected static string $resource = CalendarioResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
