<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pemasukan', function (Blueprint $table) {
            $table->integer('qty')->default(1)->after('nama');
            $table->decimal('harga', 12, 2)->nullable()->after('qty');
            $table->decimal('total', 12, 2)->nullable()->after('harga');
            $table->date('tanggal')->nullable()->after('total');
        });
    }

    public function down()
    {
        Schema::table('pemasukan', function (Blueprint $table) {
            $table->dropColumn(['qty', 'harga', 'total', 'tanggal']);
        });
    }
};
