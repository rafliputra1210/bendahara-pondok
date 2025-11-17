<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksis';

    protected $fillable = [
        'jenis',        // akan dipaksa menjadi 'pengeluaran'
        'keterangan',   // deskripsi singkat
        'jumlah',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        // kalau mau: 'jumlah' => 'integer',
    ];

    /**
     * Paksa semua transaksi menjadi 'pengeluaran'
     * saat create/update.
     */
    protected static function booted(): void
    {
        static::creating(function ($m) {
            $m->jenis = 'pengeluaran';
        });

        static::updating(function ($m) {
            if (empty($m->jenis) || $m->jenis !== 'pengeluaran') {
                $m->jenis = 'pengeluaran';
            }
        });
    }
}