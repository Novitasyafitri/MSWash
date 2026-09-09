<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemasukan', function (Blueprint $table) {
            if (!Schema::hasColumn('pemasukan', 'deskripsi')) {
                $table->string('deskripsi')->after('kategori')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('pemasukan', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
        });
    }
};
