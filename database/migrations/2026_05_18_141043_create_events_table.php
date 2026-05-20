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
        Schema::create('events', function (Blueprint $table) {
            // Menggunakan id_event sebagai primary key agar selaras dengan tabel tikets
            $table->id('id_event'); 
            
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal');
            $table->string('lokasi');
            $table->string('kategori'); // Menampung: Olahraga, Seminar, Hiburan
            $table->integer('kapasitas'); 
            $table->string('jenis')->default('individu'); // Menampung: individu / tim
            $table->string('poster')->nullable();
            $table->string('desain_tiket')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};