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

        Schema::create('mst_rombel', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sekolah_id')->nullable();
            $table->uuid('kurikulum_id')->nullable();
            $table->string('nama', 100)->nullable();
            $table->integer('tingkat')->nullable();
            $table->string('jurusan', 50)->nullable();
            $table->integer('kapasitas')->nullable();
            $table->uuid('wali_kelas_ptk_id')->nullable();
            $table->uuid('semester_id')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_rombel');
    }
};
