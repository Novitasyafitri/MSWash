<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
   Schema::create('pemasukan', function (Blueprint $table) {
        $table->id();
        $table->string('kategori');        // Layanan / Produk Tambahan / Minuman
        $table->string('nama');            // contoh: cucian biasa, sabun
        $table->integer('qty')->default(1);
        $table->integer('harga');          // harga satuan
        $table->integer('total');          // harga * qty
        $table->unsignedBigInteger('kasir_id')->nullable();
        $table->date('tanggal')->nullable();
        $table->timestamps();
    });


}
    public function down(): void
    {
        Schema::dropIfExists('pemasukan');
    }
};
