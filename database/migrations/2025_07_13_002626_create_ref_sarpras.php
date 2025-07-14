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
        Schema::create('ref_sarpras', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama')->nullable();
            $table->enum('kategori', ['Sarana', 'Prasarana'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_sarpras');
    }
};
