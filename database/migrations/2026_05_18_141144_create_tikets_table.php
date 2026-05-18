<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel tikets.
     */
    public function up(): void
    {
        Schema::create('tikets', function (Blueprint $table) {
            $table->id('id_tiket'); // Primary Key
            $table->string('nama_tiket'); // Jenis tiket: VIP, Reguler, Presale
            $table->integer('harga')->default(0); // Harga tiket (0 berarti gratis)
            $table->integer('kuota_total'); // Total kuota awal yang disediakan
            $table->integer('kuota_tersedia'); // Sisa kuota yang bisa dibeli pengunjung
            
            // Relasi Foreign Key (FK) menyambung ke tabel events
            $table->foreignId('id_event')->constrained('events', 'id_event')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};