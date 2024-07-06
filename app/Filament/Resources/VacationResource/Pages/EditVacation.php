<?php

namespace App\Filament\Resources\VacationResource\Pages;

use App\Models\User;
use Filament\Actions;
use App\Mail\VacacionAprobada;
use App\Mail\VacacionDeclinada;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\VacationResource;

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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if($data['type'] == 'aprobado'){
            $user = User::find($data['user_id']);
            $dataEnviar = [
                'nombre' => $user->name,
                'dia' => $data['dia']
            ];
            Mail::to($user)->send( new VacacionAprobada($dataEnviar));
            Notification::make()
                ->title('Vacaciones Aprobadas')
                //Icono
                ->success()
                ->body('Felicidades, tus vacaciones para el dia ' . $data['dia'] . ' fueron aprobadas')
                ->sendToDatabase($user);

        } else if($data['type'] == 'declinado') {
            $user = User::find($data['user_id']);
            $dataEnviar = [
                'nombre' => $user->name,
                'dia' => $data['dia']
            ];
            Mail::to($user)->send( new VacacionDeclinada($dataEnviar));
            Notification::make()
                ->title('Vacaciones Rechazadas')
                ->body('Lo sentimos, tus vacaciones para el dia ' . $data['dia'] . ' fueron rechazadas')
                ->danger()
                ->sendToDatabase($user);
        }
        return $data;
    }
}
