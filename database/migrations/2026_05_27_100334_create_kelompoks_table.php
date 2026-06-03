<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelompoks', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('event_id');

            $table->foreign('event_id')
                  ->references('id_event')
                  ->on('events')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->string('nama_kelompok');

            $table->integer('jumlah_anggota');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelompoks');
    }
};