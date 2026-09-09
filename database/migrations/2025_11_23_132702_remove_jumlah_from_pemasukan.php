<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('pemasukan', function (Blueprint $table) {
        $table->dropColumn('jumlah');
    });
}

public function down()
{
    Schema::table('pemasukan', function (Blueprint $table) {
        $table->decimal('jumlah', 15, 2)->nullable();
    });
}

};
