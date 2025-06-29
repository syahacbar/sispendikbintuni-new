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
            $table->string('nama_mapel', 100);
            $table->uuid('kurikulum_id');
            $table->timestamps();

            $table->foreign('kurikulum_id')->references('id')->on('tbl_kurikulums');
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
