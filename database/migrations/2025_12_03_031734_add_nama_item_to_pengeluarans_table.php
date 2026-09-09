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
    Schema::table('pengeluarans', function (Blueprint $table) {
        $table->string('nama_item')->nullable();
    });
}

public function down()
{
    Schema::table('pengeluarans', function (Blueprint $table) {
        $table->dropColumn('nama_item');
    });
}
};
