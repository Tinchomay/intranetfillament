<?php

namespace App\Filament\Personal\Resources\HorarioResource\Pages;

use App\Filament\Personal\Resources\HorarioResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateHorario extends CreateRecord
{
    protected static string $resource = HorarioResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
