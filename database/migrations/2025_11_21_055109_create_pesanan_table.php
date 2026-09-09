<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('pesanan', function (Blueprint $table) {
    $table->id();
    $table->date('tanggal');
    $table->unsignedBigInteger('produk_id')->nullable();
    $table->integer('qty')->default(1);
    $table->string('plat')->nullable();
    $table->decimal('total', 12, 2)->default(0);
    $table->timestamps();
});

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
