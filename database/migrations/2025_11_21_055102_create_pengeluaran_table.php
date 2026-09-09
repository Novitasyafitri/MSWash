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
  Schema::create('pengeluarans', function (Blueprint $table) {
    $table->id();
    $table->string('jenis');          // misal 'kasbon', 'pembayaran', dll
    $table->unsignedBigInteger('karyawan_id');
    $table->bigInteger('nominal');
    $table->string('keterangan')->nullable();
    $table->boolean('lunas')->default(false);
    $table->date('tanggal')->nullable();
    $table->timestamps();

    $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
});



}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran');
    }
};
