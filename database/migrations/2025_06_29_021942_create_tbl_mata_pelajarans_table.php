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
        Schema::create('tbl_mata_pelajarans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sekolah_id');
            $table->string('kode_mapel')->nullable();
            $table->string('nama_mapel', 100);
            $table->uuid('kelompok_mapels_id');
            $table->enum('jenjang', ['TK', 'KB', 'TPA', 'SPS', 'PKBM', 'SKB', 'SD', 'SMP', 'SMK', 'SMA', 'SLB']);
            $table->uuid('kurikulum_id');
            $table->boolean('is_praktik')->default(false);
            $table->timestamps();

            // Foreign keys
            $table->foreign('sekolah_id')->references('id')->on('tbl_sekolahs')->onDelete('cascade');
            $table->foreign('kelompok_mapels_id')->references('id')->on('tbl_kelompok_mapels')->onDelete('cascade');
            $table->foreign('kurikulum_id')->references('id')->on('tbl_kurikulums')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_mata_pelajarans');
    }
};
