<?php

namespace App\Filament\Widgets;

use App\Models\Vacation;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class User extends ChartWidget
{
    protected static ?string $heading = 'Vacaciones';

    //Podemos añadir descripciones
    public function getDescription(): ?string
    {
        return 'Resumen de vacaciones autorizadas del año';
    }

    protected int | string | array $columnSpan = 'full';

    protected static ?string $maxHeight = '170px';

    protected function getData(): array
    {
        //Necesitamos crear una variable llamada data, el modelo entre parentesis es sobre el modelo en el que queremos trabajar
        //Tambien podemos trabajar con querys
        $data = Trend::query(Vacation::where('type', 'aprobado'))
        //Seleccionamos el rango
            //Cambiando columna
            // ->dateColumn('dia_entrada')
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();
        return [
            'datasets' => [
                [
                    'label' => 'Vacaciones Pedidas',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
    protected function getType(): string
    {
        return 'bar';
    }
}
