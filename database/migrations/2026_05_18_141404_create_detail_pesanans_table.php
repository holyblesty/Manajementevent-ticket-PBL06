<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel detail_pesanans.
     */
    public function up(): void
    {
        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->id('id_detail'); // Primary Key
            $table->integer('jumlah_beli'); // Jumlah tiket yang dibeli untuk jenis tiket tersebut
            $table->integer('subtotal_harga'); // total harga (jumlah beli x harga tiket)
            $table->string('status_checkin')->default('Belum Checkin'); // Status saat di lokasi acara: Belum Checkin / Sudah Checkin
            
            // Relasi Foreign Key (FK) menyambung ke tabel pesanans induk
            $table->foreignId('id_pesanan')->constrained('pesanans', 'id_pesanan')->onDelete('cascade');
            // Relasi Foreign Key (FK) menyambung ke tabel tikets untuk tahu tiket mana yang dibeli
            $table->foreignId('id_tiket')->constrained('tikets', 'id_tiket')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanans');
    }
};