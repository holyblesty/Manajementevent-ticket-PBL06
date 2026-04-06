<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengunjungController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard-pengunjung', [PengunjungController::class, 'dashboard']);
