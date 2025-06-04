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
        Schema::create('uraian_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('uraian_kegiatan');
            $table->text('keterangan');
            $table->integer('batas_max');
            $table->integer('biaya_satuan');
            $table->integer('volume');
            $table->string('satuan');
            // $table->foreignId('sub_kategori_rab_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('sub_kategori_id');
            $table->foreign('sub_kategori_id')->references('id')->on('sub_kategori_rabs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uraian_kegiatans');
    }
};
