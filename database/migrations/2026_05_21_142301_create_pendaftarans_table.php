<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('pengunjung_id');
            $table->unsignedBigInteger('event_id');

            $table->date('tanggal_daftar');

            $table->enum('status', [
                'Menunggu',
                'Berhasil',
                'Dibatalkan'
            ])->default('Menunggu');

            $table->timestamps();

            $table->foreign('pengunjung_id')
                  ->references('id')
                  ->on('pengunjungs')
                  ->onDelete('cascade');

            $table->foreign('event_id')
                  ->references('id')
                  ->on('events')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};