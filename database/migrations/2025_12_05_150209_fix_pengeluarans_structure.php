<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pengeluarans', function (Blueprint $table) {

            /* =====================================================
                1️⃣ ENUM JENIS PERBAIKI SESUAI SISTEM FINAL
            ===================================================== */
            if (Schema::hasColumn('pengeluarans', 'jenis')) {
                $table->enum('jenis', [
                    'kasbon',
                    'stok_barang',
                    'minuman',
                    'makan_karyawan',
                    'minum_karyawan',
                    'tagihan',
                    'lain_lain'
                ])->change();
            }

            /* =====================================================
                2️⃣ TAMBAHKAN nama_item JIKA BELUM ADA
            ===================================================== */
            if (!Schema::hasColumn('pengeluarans', 'nama_item')) {
                $table->string('nama_item')->nullable()->after('produk_id');
            }

            /* =====================================================
                3️⃣ UBAH deskripsi → keterangan jika perlu
            ===================================================== */
            if (Schema::hasColumn('pengeluarans', 'deskripsi')) {
                $table->renameColumn('deskripsi', 'keterangan');
            }

            /* =====================================================
                4️⃣ TAMBAHKAN produk_id JIKA BELUM ADA
            ===================================================== */
            if (!Schema::hasColumn('pengeluarans', 'produk_id')) {
                $table->unsignedBigInteger('produk_id')->nullable()->after('karyawan_id');
            }

            /* =====================================================
                5️⃣ TAMBAH FOREIGN KEY produk_id
            ===================================================== */
            if (!Schema::hasColumn('pengeluarans', 'produk_id')) return;

            $table->foreign('produk_id')
                ->references('id')
                ->on('produks')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        // Tidak rollback ENUM untuk menjaga data aman
    }
};
