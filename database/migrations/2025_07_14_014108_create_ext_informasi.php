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
        Schema::create('ext_informasi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('judul')->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('kategori', ['Berita', 'Kegiatan', 'Pengumuman'])->nullable();
            $table->string('gambar')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->unsignedBigInteger('lihat')->default(0)->nullable();
            $table->uuid('users_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ext_informasi');
    }
};
