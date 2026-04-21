<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AcaraController;

/*
|--------------------------------------------------------------------------
| Web Routes - Admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // Kelola Acara (Resource Routes)
    Route::resource('acara', AcaraController::class)->names([
        'index'   => 'acara.index',
        'create'  => 'acara.create',
        'store'   => 'acara.store',
        'edit'    => 'acara.edit',
        'update'  => 'acara.update',
        'destroy' => 'acara.destroy',
    ]);

});