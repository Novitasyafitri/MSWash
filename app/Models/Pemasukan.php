<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    protected $table = 'pemasukan';

    protected $fillable = [
        'kategori',
        'item',
        'deskripsi',
        'qty',
        'harga',
        'total',
        'tanggal',
        'periode_id',
        'plat',
        'produk_id',
        'kasir_id',
        'nama',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}

?>
