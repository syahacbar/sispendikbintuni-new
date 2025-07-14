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
        // Tambah foreign key ke mst_sekolah
        Schema::table('mst_sekolah', function (Blueprint $table) {
            $table->string('kode_wilayah')->after('alamat')->nullable();
            $table->foreign('kode_wilayah')
                ->references('kode')->on('ref_wilayah')
                ->nullOnDelete(); 

            $table->string('kode_jenjang')->after('status')->nullable();
            $table->foreign('kode_jenjang')
                ->references('kode')->on('ref_jenjang_pendidikan')
                ->nullOnDelete();
    });

    }

    public function down(): void
    {
        Schema::table('mst_sekolah', function (Blueprint $table) {
            $table->dropForeign(['kode_wilayah']);
            $table->dropColumn('kode_wilayah');

            $table->dropForeign(['kode_jenjang']);
            $table->dropColumn('kode_jenjang');
        });
    }
};
