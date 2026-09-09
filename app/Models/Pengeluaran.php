<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $table = 'pengeluarans'; // ← SUDAH SESUAI DENGAN DATABASE

    protected $fillable = [
    'jenis',
    'periode_id',
    'karyawan_id',
    'produk_id',
    'nama_item',
    'qty',
    'nominal',
    'total',
    'keterangan',
    'tanggal',
    'lunas',
];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
