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
        Schema::create('tbl_registrasi_peserta_didiks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('peserta_didik_id');
            $table->date('tanggal_masuk');
            $table->string('jenis_pendaftaran', 50);
            $table->string('asal_sekolah')->nullable();
            $table->timestamps();

            $table->foreign('peserta_didik_id')->references('id')->on('tbl_peserta_didiks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_registrasi_peserta_didiks');
    }
};
