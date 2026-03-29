<?php

// database/migrations/2025_11_05_000001_add_keterangan_to_pembayaran_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// 'siswa_id',
// 'nama_santri',
// 'keterangan',
// 'jenis',
// 'jumlah',
// 'total_tagihan',
// 'status',

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_santri');
            $table->unsignedBigInteger('siswa_id')
                ->nullable();

            $table->foreign('siswa_id')
                ->references('id')
                ->on('siswa')
                ->onDelete('set null');
            $table->string('keterangan')->nullable();
            $table->string('jenis');
            $table->integer('jumlah');
            $table->integer('total_tagihan');
            $table->enum('status', ['Lunas', 'Belum Lunas'])
                ->default('Belum Lunas');  // posisinya setelah kolom jumlah
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropIfExists('pembayaran');
        });
    }
};
