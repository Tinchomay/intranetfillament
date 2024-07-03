<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vacation;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $empleados = User::count();
        $vacaciones_pendientes = Vacation::where('type', 'pendiente')->count();
        $vacaciones_aprobadas = Vacation::where('type', 'aprobado')
            ->whereDate('dia', '>', Carbon::now())
            ->count();
        return [
            Stat::make('Empleados', $empleados),
            Stat::make('Vacaciones Pendientes', $vacaciones_pendientes)
                ->description('Vacaciones pendintes de aprobar'),
            Stat::make('Vacaciones Aprobadas', $vacaciones_aprobadas)
                ->description('Vacaciones autorizadas a partir de hoy ' . Carbon::now()->format('d-m-Y')),
        ];
    }
}
