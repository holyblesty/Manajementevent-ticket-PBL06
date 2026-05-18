<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel kategori_events.
     */
    public function up(): void
    {
        Schema::create('kategori_events', function (Blueprint $table) {
            $table->id('id_kategori'); // Primary Key
            $table->string('nama_kategori'); // Tempat menyimpan nama kategori (Futsal, Konser, dll)
            $table->timestamps(); // Mengisi otomatis created_at dan updated_at
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_events');
    }
};