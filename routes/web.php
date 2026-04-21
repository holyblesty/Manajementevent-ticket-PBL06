<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Admin\ParticipantController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// GROUP UTAMA ADMIN
Route::prefix('admin')->name('admin.')->group(function () {

    // Fitur Kelola Acara 
    Route::resource('acara', AcaraController::class)->names([
        'index'   => 'acara.index',
        'create'  => 'acara.create',
        'store'   => 'acara.store',
        'edit'    => 'acara.edit',
        'update'  => 'acara.update',
        'destroy' => 'acara.destroy',
    ]);

    // Fitur Kelola Peserta
    Route::prefix('peserta')->name('peserta.')->group(function () {
        Route::get('/', [ParticipantController::class, 'index'])->name('index');
        Route::get('/futsal', [ParticipantController::class, 'showTeam'])->name('team');
        Route::get('/seminar', [ParticipantController::class, 'showIndividual'])->name('individual');
    });

});