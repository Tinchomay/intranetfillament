<?php

namespace App\Filament\Personal\Resources\VacationResource\Pages;

use App\Filament\Personal\Resources\VacationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateVacation extends CreateRecord
{
    protected static string $resource = VacationResource::class;

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
