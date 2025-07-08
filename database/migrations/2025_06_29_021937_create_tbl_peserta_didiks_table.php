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
        Schema::create('tbl_peserta_didiks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sekolah_id')->nullable();
            $table->string('nama', 100);
            $table->string('nisn', 10);
            $table->string('nik', 20);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tgl_lahir');
            $table->uuid('rombongan_belajar_id')->nullable();
            $table->text('alamat_jalan')->nullable();
            $table->string('desa_kelurahan', 100)->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kabupaten', 100)->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->timestamps();

            $table->foreign('rombongan_belajar_id')->references('id')->on('tbl_rombongan_belajars')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_peserta_didiks');
    }
};
