<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tbl_pengaduans', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('nomor_laporan')->nullable()->unique();
            $table->string('nama_pelapor');
            $table->string('judul_laporan');
            $table->string('email');
            $table->string('no_hp');
            $table->string('kategori');
            $table->string('dok_lampiran')->nullable();
            $table->text('isi');
            $table->string('status')->default('terkirim');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_pengaduans');
    }
};
