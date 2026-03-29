<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans'; // ⬅️ WAJIB

    protected $fillable = [
        'siswa_id',
        'nama_santri',
        'keterangan',
        'jenis',
        'jumlah',
        'total_tagihan',
        'status',
    ];
}
