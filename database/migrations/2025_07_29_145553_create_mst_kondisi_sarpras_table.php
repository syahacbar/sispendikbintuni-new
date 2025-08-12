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
            $table->uuid('id_mst_sarpras')->nullable();
            $table->string('jumlah')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('kondisi', ['Baik', 'Rusak Ringan',  'Rusak Sedang', 'Rusak Berat'])->nullable();
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
