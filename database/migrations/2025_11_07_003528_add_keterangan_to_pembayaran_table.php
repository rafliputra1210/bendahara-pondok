<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom hanya jika BELUM ada
        if (!Schema::hasColumn('pembayaran', 'keterangan')) {
            Schema::table('pembayaran', function (Blueprint $table) {
                $table->string('keterangan')->nullable()->after('nama_santri');
            });
        }
    }

    public function down(): void
    {
        // Hapus kolom hanya jika ADA
        if (Schema::hasColumn('pembayaran', 'keterangan')) {
            Schema::table('pembayaran', function (Blueprint $table) {
                $table->dropColumn('keterangan');
            });
        }
    }
};
