<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id('id_pemesanan');
            $table->unsignedBigInteger('id_pengunjung');
            $table->unsignedBigInteger('id_event');
            $table->string('jenis_tiket'); // Early Bird, Normal, VIP
            $table->integer('jumlah_tiket');
            $table->integer('harga_satuan');
            $table->integer('biaya_layanan')->default(5000);
            $table->integer('total_harga');
            $table->string('metode_pembayaran');
            $table->string('status_pembayaran')->default('Pending'); // Pending, Sukses, Batal
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('id_pengunjung')->references('id_pengunjung')->on('users')->onDelete('cascade');
            // Catatan: Pastikan tabel events menggunakan primary key id_event
        });
    }

    public function down()
    {
        Schema::dropIfExists('pemesanan');
    }
};