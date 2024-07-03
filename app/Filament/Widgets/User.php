<?php

namespace App\Filament\Widgets;

use App\Models\Vacation;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class User extends ChartWidget
{
    protected static ?string $heading = 'Vacaciones';



    protected function getData(): array
    {
        return [
            //Aqui especificamos los datos que llevara nuestro chart
            'datasets' => [
                [
                    //label seran los labels
                    'label' => 'Vacaciones Pedidas',
                    //Estos seran los datos que llevaran los labels
                    'data' => $this->obtenerDatos(),
                ],
            ],
            //La parte de abajo de los datos para especificar a que pertenecen
            'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        ];
    }

    protected function obtenerDatos()
    {
        $arregloConIndices  = Vacation::select(DB::raw('MONTH(dia) as mes'), DB::raw('count(*) as total'))
            ->whereYear('dia', '2024')
            ->groupBy('mes')
            ->orderBy('mes', 'asc')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->mes => $item->total];
            })->toArray();
        $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        $arregloConNombresDeMeses = [];
        foreach ($arregloConIndices as $indice => $valor) {
            $nombreMes = $meses[$indice];
            $arregloConNombresDeMeses[$nombreMes] = $valor;
        }
        return $arregloConNombresDeMeses ;
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
