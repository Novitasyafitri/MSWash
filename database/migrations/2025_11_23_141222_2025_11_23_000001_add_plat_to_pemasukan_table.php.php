<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pemasukan', function (Blueprint $table) {
            if (!Schema::hasColumn('pemasukan', 'plat')) {
                $table->string('plat')->nullable()->after('tanggal');
            }
            // pastikan kolom qty,harga,total,tanggal ada (sesuaikan tipe)
            if (!Schema::hasColumn('pemasukan','qty')) {
                $table->integer('qty')->default(1)->after('nama');
            }
            if (!Schema::hasColumn('pemasukan','harga')) {
                $table->decimal('harga', 12, 2)->nullable()->after('qty');
            }
            if (!Schema::hasColumn('pemasukan','total')) {
                $table->decimal('total', 12, 2)->nullable()->after('harga');
            }
            if (!Schema::hasColumn('pemasukan','tanggal')) {
                $table->date('tanggal')->nullable()->after('total');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pemasukan', function (Blueprint $table) {
            if (Schema::hasColumn('pemasukan','plat')) $table->dropColumn('plat');
            // jangan drop kolom lain kalau masih dipakai; hapus kalau memang ingin rollback penuh
        });
    }
};