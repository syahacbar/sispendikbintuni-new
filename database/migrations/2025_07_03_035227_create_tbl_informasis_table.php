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
        Schema::create('tbl_informasis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sekolah_id');
            $table->string('judul', 100);
            $table->text('deskripsi')->nullable();
            $table->enum('kategori', ['Berita', 'Kegiatan', 'Pengumuman']);
            $table->string('gambar')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();

            $table->foreign('sekolah_id')->references('id')->on('tbl_sekolahs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_informasis');
    }
};
