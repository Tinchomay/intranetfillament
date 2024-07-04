<?php

namespace App\Filament\Personal\Widgets;

use App\Models\Horario;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class totalHorasStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Tiempo trabajo el dia de hoy', $this->obtenerHoras()),
            Stat::make('Tiempo descansado el dia de hoy', $this->obtenerDescanso())
        ];
    }

    protected function obtenerHoras()
    {
        $horarios = Horario::where('user_id', Auth::user()->id)
                    ->where('type', 'trabajo')
                    ->whereDate('created_at', '=', Carbon::today()->toDateString())
                    ->get();
        $totalSegundos = 0;
        foreach($horarios as $horario){
            $horaInicio = Carbon::parse($horario->dia_entrada);
            $horaFinal = Carbon::parse($horario->dia_salida);

            $duracionTotal = $horaInicio->diffInSeconds($horaFinal);
            $totalSegundos = $totalSegundos + $duracionTotal;
        }
        $totalHoras = gmdate("H:i:s", $totalSegundos);
        return $totalHoras;
    }

    protected function obtenerDescanso()
    {
        $horarios = Horario::where('user_id', Auth::user()->id)
                    ->where('type', 'pausa')
                    ->whereDate('created_at', '=', Carbon::today()->toDateString())
                    ->get();
        $totalSegundos = 0;
        foreach($horarios as $horario){
            $horaInicio = Carbon::parse($horario->dia_entrada);
            $horaFinal = Carbon::parse($horario->dia_salida);

            $duracionTotal = $horaInicio->diffInSeconds($horaFinal);
            $totalSegundos = $totalSegundos + $duracionTotal;
        }
        $totalHoras = gmdate("H:i:s", $totalSegundos);
        return $totalHoras;
    }
}
