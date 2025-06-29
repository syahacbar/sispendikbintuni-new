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
        Schema::create('tbl_rombel_mapels', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('rombongan_belajar_id');
            $table->uuid('mata_pelajaran_id');
            $table->uuid('ptk_id');
            $table->integer('jam_mengajar');
            $table->timestamps();

            $table->foreign('rombongan_belajar_id')->references('id')->on('tbl_rombongan_belajars');
            $table->foreign('mata_pelajaran_id')->references('id')->on('tbl_mata_pelajarans');
            $table->foreign('ptk_id')->references('id')->on('tbl_ptks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_rombel_mapels');
    }
};
