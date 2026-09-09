<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('pengeluarans', function (Blueprint $table) {
        $table->id();
        $table->enum('jenis', ['kasbon', 'minuman', 'produk_tambahan']);
        $table->unsignedBigInteger('karyawan_id')->nullable();
        $table->unsignedBigInteger('produk_id')->nullable();
        $table->bigInteger('nominal')->default(0);
        $table->bigInteger('total')->default(0);
        $table->string('keterangan')->nullable();
        $table->tinyInteger('lunas')->default(0);
        $table->date('tanggal')->nullable();
        $table->timestamps();

                $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::dropIfExists('pengeluarans');
}

};
