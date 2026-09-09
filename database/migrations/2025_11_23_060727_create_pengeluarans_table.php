<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('pengeluarans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('karyawan_id')->nullable()->constrained()->onDelete('cascade');
    $table->string('jenis'); 
    $table->bigInteger('nominal');
    $table->string('deskripsi')->nullable();
    $table->boolean('lunas')->default(false);
    $table->date('tanggal')->nullable();
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};
