<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
class BackupController extends Controller
{
    public function executeCommand()
    {
        // Ejecuta el comando 'migrate' de Artisan
        $output = Artisan::call('backup:run');

        // Retorna la salida del comando (opcional)
        //return $output;

        // O también, si quieres enviar la salida en el mensaje de la vista
        return view('outputbackup', ['output' => Artisan::output()]);
    }
}
