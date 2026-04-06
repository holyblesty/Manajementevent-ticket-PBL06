<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard-pengunjung', [PengunjungController::class, 'dashboard']);
Route::get('/pendaftaran', [PengunjungController::class, 'pendaftaran']);
Route::get('/pembayaran', [PembayaranController::class, 'index']);
Route::post('/pembayaran/proses', [PembayaranController::class, 'proses']);
Route::get('/about', [PageController::class, 'about']);
Route::get('/contact', [PageController::class, 'contact']);