<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengeluaran', function (Blueprint $table) {
            if (!Schema::hasColumn('pengeluaran', 'deskripsi')) {
                $table->string('deskripsi')->after('kategori')->nullable();
            }
            if (!Schema::hasColumn('pengeluaran', 'karyawan_id')) {
                $table->unsignedBigInteger('karyawan_id')->nullable()->after('deskripsi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pengeluaran', function (Blueprint $table) {
            if (Schema::hasColumn('pengeluaran', 'deskripsi')) {
                $table->dropColumn('deskripsi');
            }
            if (Schema::hasColumn('pengeluaran', 'karyawan_id')) {
                $table->dropColumn('karyawan_id');
            }
        });
    }
};
