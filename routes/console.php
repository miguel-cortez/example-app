<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


// MACV: Las siguientes líneas han sido agregadas para crear backups automáticos
// con Laravel-Backup

//Schedule::command('backup:clean')->daily()->at('09:24');
//Schedule::command('backup:run')->daily()->at('22:38:00');
Schedule::command('backup:run')->everyMinute();