<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// halaman awal
Route::get('/', function () {
    return view('welcome');
});

// ================= ADMIN =================
// TANPA MIDDLEWARE DULU (biar tidak error login)
Route::prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

});

// OPTIONAL (biar kalau nanti middleware aktif gak error)
Route::get('/login', function () {
    return "Halaman Login (belum dibuat)";
})->name('login');
