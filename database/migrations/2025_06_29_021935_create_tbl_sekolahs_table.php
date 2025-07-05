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
        Schema::create('tbl_sekolahs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('npsn', 10)->unique();
            $table->string('nama', 100);
            $table->string('jenjang', 50);
            $table->text('alamat_jalan')->nullable();
            $table->string('desa_kelurahan', 100)->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kabupaten', 100)->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->enum('status_sekolah', ['Negeri', 'Swasta']);
            $table->char('akreditasi', 1)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('sk_pendirian', 100)->nullable();
            $table->date('tanggal_sk_pendirian')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_sekolahs');
    }
};
