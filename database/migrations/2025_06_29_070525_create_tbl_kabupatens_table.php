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
        Schema::create('tbl_kabupatens', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('provinsi_id')->constrained('tbl_provinsis')->cascadeOnDelete();
            $table->string('nama');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_kabupatens');
    }
};
