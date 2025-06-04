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
        Schema::create('sub_kategori_rabs', function (Blueprint $table) {
            $table->id();
            $table->string('sub_kategori');
            $table->unsignedBigInteger('kategori_rabs_id');
            $table->foreign('kategori_rabs_id')->references('id')->on('kategori_rabs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_kategori_rabs');
    }
};
