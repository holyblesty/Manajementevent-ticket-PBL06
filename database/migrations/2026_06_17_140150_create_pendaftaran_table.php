<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendaftaran', function (Blueprint $table) {

            // Primary Key
            $table->id('id_pendaftaran');

            // Foreign Key ke tabel events
            $table->unsignedBigInteger('id_event');

            // Foreign Key ke tabel tiket
            $table->unsignedBigInteger('id_tiket');

            // Data peserta
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('no_hp');

            // Detail pemesanan
            $table->integer('jumlah_tiket');
            $table->integer('total_harga');

            // Status pembayaran
            $table->enum('status_pembayaran', [
                'Belum Bayar',
                'Sudah Bayar'
            ])->default('Belum Bayar');

            $table->timestamps();

            // Relasi dengan tabel events
            $table->foreign('id_event')
                  ->references('id_event')
                  ->on('events')
                  ->onDelete('cascade');

            // Relasi dengan tabel tiket
            $table->foreign('id_tiket')
                  ->references('id_tiket')
                  ->on('tiket')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};