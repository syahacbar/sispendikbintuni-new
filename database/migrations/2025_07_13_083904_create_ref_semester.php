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
        Schema::create('ref_semester', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_semester')->unique();
            $table->string('tahun_ajaran');
            $table->string('nama_semester');
            $table->boolean('is_aktif')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_semester');
    }
};
