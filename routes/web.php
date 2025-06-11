<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BackupController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("/bk", function(){
    //$output = shell_exec("C:/wamp64/bin/mysql/mysql9.1.0/bin/mysqldump --ssl-mode=DISABLED -u root example_app > C:/wamp64/www/example_app/public/borrame.sql");
    $output = shell_exec("C:/wamp64/bin/mysql/mysql9.1.0/bin/mysqldump -u root example_app > C:/Users/macv/Documents/example_app.sql");
    //$output = shell_exec("dir");
    echo $output;
});

Route::get('/backup', [BackupController::class, 'executeCommand'])->name('backup.database');

Route::get('/dashboard/{p1?}', function () {
    return view('dashboard_menubar');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
