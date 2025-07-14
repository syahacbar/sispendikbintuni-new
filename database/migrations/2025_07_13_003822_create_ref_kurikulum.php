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
        Schema::create('ref_kurikulum', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode');
            $table->string('nama');
            $table->enum('jenis', ['Nasional', 'Muatan Lokal', 'Lainnya']);
            $table->year('tahun_mulai');
            $table->enum('status', ['Aktif', 'Tidak Aktif']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_kurikulum');
    }
};
