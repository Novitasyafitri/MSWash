<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan'; // pastikan ini sesuai nama tabel migration

    protected $fillable = [
        'tanggal',
        'produk_id',
        'deskripsi',
        'kategori',
        'plat',
        'harga',
        'kasir_id',
        'jumlah',
        'cuci_ke_6_gratis',
    ];
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
