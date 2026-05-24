<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('registrations', function (Blueprint $table) {
        $table->id('id_registration');
        $table->foreignId('id_event')->constrained('events', 'id_event')->onDelete('cascade');
        $table->string('nama_tim')->nullable();
        $table->string('kontak')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};