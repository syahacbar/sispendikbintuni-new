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
        Schema::create('tbl_sarpras', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sekolah_id');
            $table->uuid('jenis_sarpras_id');
            $table->enum('kategori', ['Sarana', 'Prasarana']);
            $table->integer('jumlah_ideal');
            $table->integer('jumlah_saat_ini');
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat']);
            $table->enum('kurang_lebih', ['Kurang', 'Lebih']);
            $table->text('keterangan');
            $table->timestamps();

            // Foreign keys
            $table->foreign('sekolah_id')->references('id')->on('tbl_sekolahs')->onDelete('cascade');
            $table->foreign('jenis_sarpras_id')->references('id')->on('tbl_jenis_sarpras')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_sarpras');
    }
};
