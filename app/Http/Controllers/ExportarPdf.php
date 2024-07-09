<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportarPdf extends Controller
{
    public function horarios(User $user)
    {
        $horarios = Horario::where('user_id', $user->id)->get();
        $pdf = Pdf::loadView('pdf.example', ['horarios' => $horarios]);
        return $pdf->download('invoice.pdf');
    }
}
