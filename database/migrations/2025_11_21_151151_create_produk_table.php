<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukTable extends Migration
{
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('harga')->default(0);

            // kategori hanya 3 macam
            $table->enum('kategori', [
                'Mobil',
                 'Motor',
                  'Karpet',
                'Produk Tambahan',
                'Minuman'
            ]);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produk');
    }
}
