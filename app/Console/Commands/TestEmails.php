<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Vacation;
use Illuminate\Console\Command;
use App\Mail\VacacionesPendientes;
use Illuminate\Support\Facades\Mail;

class TestEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Buscamos el user al que le vamos a mandar el mail
        $user = User::find(3);
        //Mandamos un email al user con la instancia de vacaciones pendientes
        Mail::to($user)->send( new VacacionesPendientes);
    }
}
