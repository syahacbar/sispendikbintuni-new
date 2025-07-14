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
        Schema::create('mst_peserta_didik', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama', 100);
            $table->string('nisn', 10)->nullable();
            $table->string('nik', 20)->nullable();
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->enum('agama', ['Islam', 'Kristen', 'Hindu', 'Buddha', 'Konghucu']);
            $table->text('alamat')->nullable();
            $table->string('kode_wilayah', 100)->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_peserta_didik');
    }
};
