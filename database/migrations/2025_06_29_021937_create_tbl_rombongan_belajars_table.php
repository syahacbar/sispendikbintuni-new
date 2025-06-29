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
        Schema::create('tbl_rombongan_belajars', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sekolah_id');
            $table->uuid('wali_ptk_id');
            $table->string('nama_rombel', 50);
            $table->integer('tingkat_kelas');
            $table->string('semester', 6);
            $table->uuid('kurikulum_id');
            $table->timestamps();

            // Foreign Keys
            $table->foreign('sekolah_id')->references('id')->on('tbl_sekolahs')->onDelete('cascade');
            $table->foreign('wali_ptk_id')->references('id')->on('tbl_ptks')->onDelete('set null');
            $table->foreign('kurikulum_id')->references('id')->on('tbl_kurikulums')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_rombongan_belajars');
    }
};
