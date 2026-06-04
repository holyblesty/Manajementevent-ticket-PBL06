<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Buat tabel pengunjungs.
     */
    public function up(): void
    {
        Schema::create('pengunjungs', function (Blueprint $table) {
            $table->id();

            $table->string('nama_lengkap', 100);
            $table->string('username', 50)->unique();
            $table->string('email', 150)->unique();
            $table->string('password');

            $table->string('no_telepon', 20)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto')->nullable();

            $table->enum('metode_login', ['Email', 'Google', 'Facebook'])->default('Email');
            $table->enum('status_akun', ['Aktif', 'Nonaktif', 'Banned'])->default('Aktif');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Hapus tabel pengunjungs.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengunjungs');
    }
};