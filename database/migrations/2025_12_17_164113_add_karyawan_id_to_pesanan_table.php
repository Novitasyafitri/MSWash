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
    Schema::table('pesanan', function (Blueprint $table) {
        $table->unsignedBigInteger('karyawan_id')->nullable()->after('kasir_id');

        $table->foreign('karyawan_id')
              ->references('id')
              ->on('karyawans')
              ->nullOnDelete();
    });
}

public function down(): void
{
    Schema::table('pesanan', function (Blueprint $table) {
        $table->dropForeign(['karyawan_id']);
        $table->dropColumn('karyawan_id');
    });
}

};
