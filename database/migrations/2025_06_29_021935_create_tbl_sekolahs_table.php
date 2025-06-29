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
            $table->text('alamat');
            $table->string('kode_wilayah', 10)->nullable();
            $table->enum('status_sekolah', ['Negeri', 'Swasta']);
            $table->char('akreditasi', 1);
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
