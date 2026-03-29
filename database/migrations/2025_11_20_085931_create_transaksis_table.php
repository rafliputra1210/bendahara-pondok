<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('jenis')->nullable(); // contoh: 'pemasukan' atau 'pengeluaran'
            $table->decimal('jumlah', 15, 2)->default(0);
            $table->string('keterangan')->nullable();
            $table->date('tanggal')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // opsional, pemakai yang menginput
            $table->timestamps();

            // index (opsional)
            $table->index('jenis');
            $table->index('tanggal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
