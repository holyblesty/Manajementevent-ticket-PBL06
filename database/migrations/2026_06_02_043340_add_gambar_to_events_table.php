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
        Schema::table('events', function (Blueprint $table) {

            // KOLOM UNTUK MENYIMPAN PATH GAMBAR
            $table->string('gambar')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {

            // HAPUS KOLOM GAMBAR
            $table->dropColumn('gambar');

        });
    }
};