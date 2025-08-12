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
        Schema::create('mst_gtk', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('nama', 100);
            $table->string('nik', 20)->nullable();
            $table->string('nip', 20)->nullable();
            $table->string('nuptk', 20)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('tempat_tugas')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('status_kepegawaian')->nullable();
            $table->enum('jenis_gtk', ['Guru', 'Kepala Sekolah', 'Tenaga Kependidikan'])->nullable();
            $table->string('pend_terakhir')->nullable();
            $table->enum('status_keaktifan', ['Aktif', 'Tidak Aktif'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_gtk');
    }
};
