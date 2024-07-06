<?php

namespace App\Filament\Personal\Resources\VacationResource\Pages;

use App\Models\User;
use Filament\Actions;
use App\Mail\VacacionesPendientes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Personal\Resources\VacationResource;

class CreateVacation extends CreateRecord
{
    protected static string $resource = VacationResource::class;

    //Aqui la data es lo que se esta creando
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;

        $userAdmin = User::find(1);

        $dataEnviar = [
            'dia' => $data['dia'],
            'nombreAdministrador' => $userAdmin->name,
            'nombre' => User::find($data['user_id'])->name,
            'email' => User::find($data['user_id'])->email,
        ];

        Mail::to($userAdmin)->send( new VacacionesPendientes($dataEnviar));

        $recipient = auth()->user();
        Notification::make()
            ->title('Registro Realizado')
            ->body('Las vacaciones se encuentran pendientes de aprobación')
            ->sendToDatabase($recipient);
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
