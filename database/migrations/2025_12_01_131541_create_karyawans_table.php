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
    Schema::create('karyawans', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->enum('jabatan', ['kasir', 'karyawan']);
        $table->date('tanggal_masuk');
        $table->integer('gaji_pokok')->default(0); // 👉 tambahkan gaji pokok bulanan
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
