<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menambah kolom baru.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kolom tambahan untuk username login, nomor HP, alamat, dan Hak Akses (Role)
            $table->string('username')->unique()->after('name');
            $table->string('no_hp')->nullable()->after('password');
            $table->text('alamat')->nullable()->after('no_hp');
            $table->enum('role', ['admin', 'pengunjung'])->default('pengunjung')->after('alamat');
        });
    }

    /**
     * Batalkan migrasi (jika melakukan rollback).
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kembali kolom jika migrasi di-cancel
            $table->dropColumn(['username', 'no_hp', 'alamat', 'role']);
        });
    }
};