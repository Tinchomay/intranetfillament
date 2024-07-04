<?php

namespace App\Filament\Personal\Resources\HorarioResource\Pages;

use Carbon\Carbon;
use Filament\Actions;
use App\Models\Horario;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Personal\Resources\HorarioResource;

class ListHorarios extends ListRecords
{
    protected static string $resource = HorarioResource::class;

    protected function getHeaderActions(): array
    {
        $userId = Auth::user()->id;
        $acciones = Horario::where('user_id', $userId)
                            ->orderBy('created_at', 'DESC')
                            ->take(2)
                            ->get();

        $ultimaAccion = $acciones->first();
        $penultimaAccion = $acciones->skip(1)->first();
        if ($ultimaAccion && (($ultimaAccion->type ?? null) == 'trabajo') && ($ultimaAccion->dia_entrada ?? null)
        && ((($penultimaAccion->type ?? null) == 'pausa') && !$ultimaAccion->dia_salida)) {

        return [
            Action::make('outWork')
                ->label('Terminar de Trabajar')
                ->color('warning')
                ->requiresConfirmation()
                ->action(function() use ($userId) {
                    $accion = Horario::where('user_id', $userId)->orderBy('created_at', 'DESC')->first();
                    $accion->dia_salida = Carbon::now();
                    $accion->save();
                    Notification::make()
                        ->title('Has terminado de trabajar')
                        ->success()
                        ->send();
                })
        ];
        } else if ($ultimaAccion && ($ultimaAccion->type ?? null) == 'pausa' && $ultimaAccion->dia_entrada ?? null) {

            return [
                Action::make('outPause')
                    ->label('Terminar Pausa')
                    ->color('info')
                    ->requiresConfirmation()
                    ->action(function() use ($userId) {
                        $accion = Horario::where('user_id', $userId)->orderBy('created_at', 'DESC')->first();
                        $accion->dia_salida = Carbon::now();
                        $accion->save();
                        Horario::create([
                            'calendario_id' => 1,
                            'user_id' => $userId,
                            'type' => 'trabajo',
                            'dia_entrada' => Carbon::now()
                        ]);
                        Notification::make()
                            ->title('Ha terminado tu pausa')
                            ->success()
                            ->send();
                    }),
            ];
        } else if ($ultimaAccion && (($ultimaAccion->type ?? null) == 'trabajo') && ($ultimaAccion->dia_entrada ?? null) && (!$ultimaAccion->dia_salida ?? null)) {
            return [
                Action::make('inPause')
                    ->label('Comenzar Pausa')
                    ->color('info')
                    ->requiresConfirmation()
                    ->action(function() use ($userId) {
                        $accion = Horario::where('user_id', $userId)->orderBy('created_at', 'DESC')->first();
                        $accion->dia_salida = Carbon::now();
                        $accion->save();
                        Horario::create([
                            'calendario_id' => 1,
                            'user_id' => $userId,
                            'type' => 'pausa',
                            'dia_entrada' => Carbon::now()
                        ]);
                        Notification::make()
                            ->title('Ha comenzado tu pausa')
                            ->success()
                            ->send();
                    }),
            ];
        } else if ((!$ultimaAccion) || ($ultimaAccion && ($ultimaAccion->type ?? null) == 'trabajo' && $ultimaAccion->dia_salida ?? null)) {
            return [
                Action::make('inwork')
                    ->label('Entrar a Trabajar')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function() use ($userId) {
                        Horario::create([
                            'calendario_id' => 1,
                            'user_id' => $userId,
                            'type' => 'trabajo',
                            'dia_entrada' => Carbon::now()
                        ]);
                        Notification::make()
                            ->title('Has comenzado a trabajar')
                            ->success()
                            ->send();
                    })
            ];
        }
        return [];
    }
}
