<?php

namespace App\Imports;

use App\Models\Calendario;
use App\Models\Horario;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

//Con withHeadingRow
class HorariosImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $calendario = Calendario::where('nombre', $row['calendario'])->first();
            $user = User::where('name', $row['usuario'])->first();
            if($calendario && $user){
                Horario::create([
                    'calendario_id' => $calendario->id,
                    'user_id' => $user->id,
                    'type' => $row['tipo'],
                    'dia_entrada' => $row['dia_entrada'],
                    'dia_salida' => $row['dia_salida']
                ]);
            }
        }
    }
}
