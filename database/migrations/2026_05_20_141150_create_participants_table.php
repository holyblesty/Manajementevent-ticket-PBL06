<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('participants', function (Blueprint $table) {
        $table->id('id_participant');
        $table->foreignId('id_registration')->constrained('registrations', 'id_registration')->onDelete('cascade');
        $table->string('nama');
        $table->string('kode');
        $table->string('email')->nullable();
        $table->string('instansi')->nullable();
        $table->boolean('hadir')->default(false);
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};