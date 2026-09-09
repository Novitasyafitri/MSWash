<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pengeluarans', function (Blueprint $table) {

            if (!Schema::hasColumn('pengeluarans', 'qty')) {
                $table->integer('qty')->nullable()->after('produk_id');
            }

        });
    }

    public function down()
    {
        Schema::table('pengeluarans', function (Blueprint $table) {
            if (Schema::hasColumn('pengeluarans', 'qty')) {
                $table->dropColumn('qty');
            }
        });
    }
};
