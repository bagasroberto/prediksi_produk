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
        Schema::create('data_bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_id')->nullable();

            $table->string('nama_bahan_baku');
            $table->integer('harga_bahan_baku')->nullable();
            // $table->integer('stok_bahan_baku')->nullable();
            // $table->integer('stok_rusak')->nullable();
            $table->string('status')->default('aktif');
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_bahan_baku');
    }
};
