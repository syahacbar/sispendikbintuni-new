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
        Schema::create('tbl_prasaranas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sekolah_id');
            $table->uuid('jenis_prasarana_id');
            $table->integer('jumlah');
            $table->enum('kondisi', ['Bagus', 'Rusak']);
            $table->timestamps();

            // Foreign keys
            $table->foreign('sekolah_id')->references('id')->on('tbl_sekolahs')->onDelete('cascade');
            $table->foreign('jenis_prasarana_id')->references('id')->on('tbl_jenis_sarpras')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_prasaranas');
    }
};
