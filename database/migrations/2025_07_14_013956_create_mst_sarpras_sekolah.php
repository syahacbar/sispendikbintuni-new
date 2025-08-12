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
        Schema::create('mst_sarpras_sekolah', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sekolah_id')->nullable();
            $table->uuid('sarpras_id')->nullable();
            $table->string('nama')->nullable();
            $table->integer('jumlah_saat_ini')->default(0);
            $table->integer('jumlah_ideal')->nullable();
            $table->integer('kondisi_baik')->nullable();
            $table->integer('kondisi_rusak_ringan')->nullable();
            $table->integer('kondisi_rusak_sedang')->nullable();
            $table->integer('kondisi_rusak_berat')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_sarpras_sekolah');
    }
};
