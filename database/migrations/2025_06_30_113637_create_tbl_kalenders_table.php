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
        Schema::create('tbl_kalenders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sekolah_id');
            $table->string('nama');
            $table->datetime('tanggal_mulai');
            $table->datetime('tanggal_akhir')->nullable();
            $table->string('deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('sekolah_id')->references('id')->on('tbl_sekolahs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_kalenders');
    }
};
