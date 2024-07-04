<?php

namespace App\Filament\Personal\Widgets;

use App\Models\Vacation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class PersonalWidgetStats extends BaseWidget
{
    protected function getStats(): array
    {
        $vacacionesPendientes = Vacation::where('user_id', Auth::user()->id)->where('type', 'pendiente')->count();
        $vacacionesAutorizadas = Vacation::where('user_id', Auth::user()->id)->where('type', 'aprobado')->where('dia', '>', now()->format('Y-m-d'))->count();
        $vacacionesRechazadas = Vacation::where('user_id', Auth::user()->id)->where('type', 'declinado')->where('dia', '>', now()->format('Y-m-d'))->count();
        $siguienteVacacion = Vacation::where('user_id', Auth::user()->id)->where('type', 'aprobado')->where('dia', '>', now()->format('Y-m-d'))->orderBy('dia', 'ASC')->first();
        return [
            Stat::make('Proximo dia de vacaciones autorizado', $siguienteVacacion ? $siguienteVacacion->dia->format('d-m-Y') : '' ),
            Stat::make('Vacaciones Pendientes', $vacacionesPendientes),
            Stat::make('Vacaciones autorizadas', $vacacionesAutorizadas),
            Stat::make('Vacaciones rechazadas', $vacacionesRechazadas),
        ];
    }
}
