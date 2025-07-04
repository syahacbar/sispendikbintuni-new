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
        Schema::create('tbl_saranas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sekolah_id');
            $table->integer('r_kelas')->nullable();
            $table->integer('r_perpus')->nullable();
            $table->integer('r_lab')->nullable();
            $table->integer('r_praktik')->nullable();
            $table->integer('r_pimpinan')->nullable();
            $table->integer('r_guru')->nullable();
            $table->integer('r_ibadah')->nullable();
            $table->integer('r_uks')->nullable();
            $table->integer('r_toilet')->nullable();
            $table->integer('r_gudang')->nullable();
            $table->integer('r_sirkulasi')->nullable();
            $table->integer('tempat_bermain')->nullable();
            $table->integer('r_tu')->nullable();
            $table->integer('r_konseling')->nullable();
            $table->integer('r_osis')->nullable();
            $table->integer('r_bangunan')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('sekolah_id')->references('id')->on('tbl_sekolahs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_saranas');
    }
};
