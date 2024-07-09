<?php

namespace App\Filament\Personal\Pages;

use Filament\Pages\Page;

class Configuracion extends Page
{
    protected static ?string $navigationLabel = 'Configuración';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.personal.pages.configuracion';
}
