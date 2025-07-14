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
        Schema::create('mst_anggota_rombel', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('rombel_id');
            $table->uuid('peserta_didik_id');
            $table->uuid('semester_id');
            $table->boolean('status_keaktifan')->default(true);
            $table->date('tanggal_masuk')->nullable();
            $table->date('tanggal_keluar')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_anggota_rombel');
    }
};
