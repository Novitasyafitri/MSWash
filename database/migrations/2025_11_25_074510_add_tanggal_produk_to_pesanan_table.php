<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            if (!Schema::hasColumn('pesanan', 'tanggal')) {
                $table->date('tanggal')->nullable()->after('id');
            }
            if (!Schema::hasColumn('pesanan', 'produk_id')) {
                $table->unsignedBigInteger('produk_id')->nullable()->after('tanggal');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn(['tanggal', 'produk_id']);
        });
    }
};
