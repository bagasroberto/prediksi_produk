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
        Schema::create('data_barang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->string('nama_barang');
            $table->integer('harga_barang')->nullable();
            $table->integer('stok_barang')->nullable();
            $table->integer('stok_rusak')->nullable();
            $table->string('status')->default('aktif');
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade');
            // $table->foreignId('kategori_id')->constrained();
            // $table->foreign('kategori_id')->references('id')->on('kategoris')->constrained();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_barang');
    }
};
