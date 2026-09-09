<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('pemasukan', function (Blueprint $table) {
        $table->unsignedBigInteger('produk_id')->nullable()->after('nama');
    });
}

public function down()
{
    Schema::table('pemasukan', function (Blueprint $table) {
        $table->dropColumn('produk_id');
    });
}

};
