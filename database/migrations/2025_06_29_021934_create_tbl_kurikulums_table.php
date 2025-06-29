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
        Schema::create('tbl_kurikulums', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode', 20);
            $table->string('nama', 100);
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
        Schema::dropIfExists('tbl_kurikulums');
    }
};
