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
        Schema::create('tbl_anggota_rombels', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('rombongan_belajar_id');
            $table->uuid('peserta_didik_id');
            $table->timestamps();

            $table->foreign('rombongan_belajar_id')->references('id')->on('tbl_rombongan_belajars');
            $table->foreign('peserta_didik_id')->references('id')->on('tbl_peserta_didiks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_anggota_rombels');
    }
};
