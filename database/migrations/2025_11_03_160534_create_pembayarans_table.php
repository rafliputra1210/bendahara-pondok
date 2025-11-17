<?php

// database/migrations/2025_11_05_000001_add_keterangan_to_pembayaran_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('pembayaran', function (Blueprint $table) {
            if (!Schema::hasColumn('pembayaran', 'keterangan')) {
                $table->string('keterangan')->nullable()->after('jenis');
            }
        });
    }
    public function down(): void {
        Schema::table('pembayaran', function (Blueprint $table) {
            if (Schema::hasColumn('pembayaran', 'keterangan')) {
                $table->dropColumn('keterangan');
            }
        });
    }
};

