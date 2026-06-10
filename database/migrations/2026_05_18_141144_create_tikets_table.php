<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tikets', function (Blueprint $table) {

            $table->id('id_tiket');

            $table->string('nama_tiket');

            $table->integer('harga');

            $table->integer('stok');

            $table->date('tanggal_event');

            $table->string('lokasi');

            $table->text('deskripsi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};

