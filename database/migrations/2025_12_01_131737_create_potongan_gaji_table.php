<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('potongan_gaji', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('karyawan_id');
        $table->unsignedBigInteger('kasbon_id');
        $table->bigInteger('jumlah');
        $table->date('tanggal');
        $table->timestamps();

        $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
        $table->foreign('kasbon_id')->references('id')->on('pengeluarans')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('potongan_gaji');
    }
};
