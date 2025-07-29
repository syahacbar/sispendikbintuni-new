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
        Schema::create('mst_kondisi_sarpras', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_mst_sarpras')->nullable(); // <- ini penting
            $table->foreign('id_mst_sarpras')->references('id')->on('mst_sarpras_sekolah')->nullOnDelete();
            $table->enum('kondisi', ['Baik', 'Rusak Ringan',  'Rusak Sedang', 'Rusak Berat'])->nullable();
            $table->string('jumlah');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_kondisi_sarpras');
    }
};
