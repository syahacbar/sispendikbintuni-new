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
        Schema::create('mst_pembelajaran', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('rombongan_belajar_id')->nullable();
            $table->uuid('mata_pelajaran_id')->nullable();
            $table->uuid('gtk_id')->nullable();
            $table->uuid('semester_id')->nullable();
            $table->integer('jam_mengajar_per_minggu')->nullable();
            $table->string('jenis_pembelajaran', 50)->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_pembelajaran');
    }
};
