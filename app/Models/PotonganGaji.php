<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class PotonganGaji extends Model
{
    protected $table = 'potongan_gaji';

    protected $fillable = [
        'karyawan_id',
        'kasbon_id',
        'jumlah',
        'tanggal',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function kasbon()
    {
        return $this->belongsTo(Pengeluaran::class, 'kasbon_id');
    }
}
