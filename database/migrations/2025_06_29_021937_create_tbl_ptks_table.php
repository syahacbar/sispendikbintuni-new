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
        Schema::create('tbl_ptks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('sekolah_id')->constrained('tbl_sekolahs')->onDelete('cascade');
            $table->string('nama', 100);
            $table->string('nuptk', 20);
            $table->string('nik', 20);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->enum('status', ['PNS', 'Honorer', 'GTY']);
            $table->date('tgl_lahir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_ptks');
    }
};
