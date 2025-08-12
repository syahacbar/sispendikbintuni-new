<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mst_sekolah', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('npsn', 10)->unique();
            $table->string('nama', 100)->nullable();
            $table->text('alamat')->nullable();
            $table->string('kode_wilayah')->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->enum('status', ['Negeri', 'Swasta'])->nullable();
            $table->string('kode_jenjang')->nullable();
            $table->enum('akreditasi', ['A', 'B', 'C', 'Belum Terakreditasi'])->nullable();
            $table->string('email', 100)->unique();
            $table->string('telepon', 20)->unique()->nullable();
            $table->string('kepemilikan', 100)->nullable();
            $table->string('sk_pendirian', 100)->nullable();
            $table->date('tanggal_sk_pendirian')->nullable();
            $table->string('sk_izin_operasional', 100)->nullable();
            $table->date('tanggal_sk_izin_operasional')->nullable();
            $table->string('latitude', 100)->nullable();
            $table->string('longitude', 100)->nullable();
            $table->unsignedBigInteger('users_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_sekolah');
    }
};
