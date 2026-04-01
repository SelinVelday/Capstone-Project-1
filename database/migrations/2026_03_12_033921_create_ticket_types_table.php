<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete(); // Relasi ke tabel events
            $table->string('name'); // Nama tiket: VIP, Reguler, dll
            $table->integer('price'); // Harga tiket
            $table->integer('quota'); // Kuota khusus untuk tiket ini
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_types');
    }
};