<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel pesanans.
     */
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id('id_pesanan'); // Primary Key
            $table->date('tgl_pesan'); // Tanggal pengunjung melakukan pemesanan
            $table->date('tgl_bayar')->nullable(); // Tanggal konfirmasi pembayaran (bisa kosong dulu pas pending)
            $table->string('metode_pembayaran')->nullable(); // Bank Transfer, E-Wallet, dll
            $table->integer('total_harga'); // Total nominal uang yang harus dibayar
            $table->integer('jumlah_tiket'); // Total jumlah tiket yang dipesan dalam satu transaksi
            $table->string('kode_registrasi')->unique(); // Kode unik (misal: TKT-180526-001) untuk check-in masuk event
            $table->string('sts_transaksi')->default('Pending'); // Status transaksi: Pending, Lunas, atau Cancel
            
            // Relasi Foreign Key (FK) menyambung ke tabel users (untuk tahu pengunjung mana yang beli)
            $table->foreignId('id_pengunjung')->constrained('users')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};