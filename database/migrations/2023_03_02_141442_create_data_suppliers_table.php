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
        Schema::create('data_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_supplier', 50);
            $table->string('alamat_supplier', 120);
            $table->string('email_supplier', 50);
            $table->string('tlp_supplier', 15);
            $table->string('status_supplier', 15)->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_suppliers');
    }
};
