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
        Schema::create('pemasukans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('jumlah');
            $table->string('spp');
            $table->string('dpp');
            $table->string('tabungan');
            $table->string('mahad');
            $table->string('kategori');
            $table->string('metode_pembayaran');
            $table->unsignedBigInteger('siswa_id');
            $table->integer('pembayaranKe');            
            $table->date('pembayaran_bulan');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasukans');
    }
};
