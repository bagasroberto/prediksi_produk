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
        Schema::create('keluar_barang', function (Blueprint $table) {
            $table->id();
            $table->integer('stok_keluar')->nullable();
            $table->date('tgl_keluar');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('data_supplier')->onDelete('cascade');
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->foreign('barang_id')->references('id')->on('data_barang')->onDelete('cascade');
            $table->unsignedBigInteger('bahan_baku_id')->nullable();
            $table->foreign('bahan_baku_id')->references('id')->on('data_bahan_baku')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluar_barang');
    }
};
