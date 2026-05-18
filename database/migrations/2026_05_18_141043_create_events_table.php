<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel events.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id('id_event'); // Primary Key
            $table->string('judul'); // Nama event/acara
            $table->text('deskripsi')->nullable(); // Penjelasan detail acara
            $table->date('tanggal'); // Tanggal pelaksanaan acara
            $table->time('jam'); // Jam mulai acara
            $table->string('lokasi'); // Tempat acara diadakan
            $table->string('poster')->nullable(); // Menyimpan nama file gambar poster
            $table->string('status_event')->default('Aktif'); // Status: Aktif, Selesai, atau Batal
            
            // Relasi Foreign Key (FK) sesuai ERD kamu
            // id_admin menyambung ke tabel users (role admin)
            $table->foreignId('id_admin')->nullable()->constrained('users')->onDelete('set null');
            // id_kategori menyambung ke tabel kategori_events
            $table->foreignId('id_kategori')->constrained('kategori_events', 'id_kategori')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};