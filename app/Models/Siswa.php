<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'nama_lengkap',
        'jk',
        'alamat',
        'kelas',
    ];

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'siswa_id');
    }
}
