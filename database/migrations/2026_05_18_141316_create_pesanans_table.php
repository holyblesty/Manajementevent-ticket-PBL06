<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pesanans', function (Blueprint $table) {

            $table->id('id_detail');

            // ==========================================
            // RELASI
            // ==========================================

            $table->unsignedBigInteger('id_pesanan');

            $table->unsignedBigInteger('id_tiket');

            // ==========================================
            // DETAIL PEMBELIAN
            // ==========================================

            $table->integer('subtotal_harga');

            $table->integer('jumlah_beli');

            $table->boolean('status_checkin')
                  ->default(false);

            $table->timestamps();

            // ==========================================
            // FOREIGN KEY
            // ==========================================

            $table->foreign('id_pesanan')
                  ->references('id_pesanan')
                  ->on('pesanans')
                  ->onDelete('cascade');

            $table->foreign('id_tiket')
                  ->references('id_tiket')
                  ->on('tikets')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pesanans');
    }
};

