<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard-pengunjung', [PengunjungController::class, 'dashboard']);
Route::get('/pendaftaran', [PengunjungController::class, 'pendaftaran']);
Route::get('/pembayaran', [PembayaranController::class, 'index']);
Route::post('/pembayaran/proses', [PembayaranController::class, 'proses']);
Route::get('/about', [PageController::class, 'about']);
Route::get('/contact', [PageController::class, 'contact']);
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/events', [AdminController::class, 'events'])->name('admin.events');
Route::get('/admin/participants', [AdminController::class, 'participants'])->name('admin.participants');
