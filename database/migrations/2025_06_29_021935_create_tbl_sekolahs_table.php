<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_sekolahs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('kurikulum_id');
            $table->string('npsn', 10)->unique();
            $table->string('nama', 100);
            $table->string('jenjang', 50);
            $table->text('alamat_jalan')->nullable();
            $table->string('desa_kelurahan', 100)->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->enum('status_sekolah', ['Negeri', 'Swasta']);
            $table->char('akreditasi', 1)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('kepemilikan', 100)->nullable();
            $table->string('sk_pendirian', 100)->nullable();
            $table->date('tanggal_sk_pendirian')->nullable();
            $table->string('sk_izin_operasional', 100)->nullable();
            $table->date('tanggal_sk_izin_operasional')->nullable();
            $table->string('lintang', 100)->nullable();
            $table->string('bujur', 100)->nullable();
            $table->string('slug')->unique();
            $table->string('kode_wilayah');
            $table->timestamps();

            $table->foreign('kurikulum_id')->references('id')->on('tbl_kurikulums')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_sekolahs');
    }
};
