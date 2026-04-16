<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom harga di tabel events
        Schema::table('events', function (Blueprint $table) {
            $table->integer('price')->default(0)->after('quota');
        });

        // 2. Tambah kolom total harga & status bayar di tabel bookings
        Schema::table('bookings', function (Blueprint $table) {
            $table->integer('total_price')->default(0)->after('quantity');
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid')->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('price');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['total_price', 'payment_status']);
        });
    }
};
