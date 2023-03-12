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
        Schema::create('stok', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->unsignedBigInteger('bahan_baku_id')->nullable();
            $table->integer('stok');
            $table->integer('stok_rusak')->nullable();
            $table->timestamps();

            $table->foreign('barang_id')->references('id')->on('data_barang')->onDelete('cascade');
            $table->foreign('bahan_baku_id')->references('id')->on('data_bahan_baku')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok');
    }
};
