<?php

use App\Http\Controllers\ExportarPdf;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/personal');
});


route::get('/pdf/generate/horarios/{user}', [ExportarPdf::class, 'horarios']
)->middleware('auth')->name('pdf.example');
