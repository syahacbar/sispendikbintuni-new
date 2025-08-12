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
        Schema::table('mst_sekolah', function (Blueprint $table) {
            $table->foreign('kode_wilayah')->references('kode')->on('ref_wilayah')->nullOnDelete();
            $table->foreign('kode_jenjang')->references('kode')->on('ref_jenjang_pendidikan')->nullOnDelete();
            $table->foreign('users_id')->references('id')->on('sys_users')->nullOnDelete();
        });

        Schema::table('mst_gtk', function (Blueprint $table) {
            $table->foreign('jenis_gtk')->references('id')->on('ref_jenis_gtk')->nullOnDelete();
            $table->foreign('tempat_tugas')->references('npsn')->on('mst_sekolah')->nullOnDelete();
        });


        Schema::table('mst_rombel', function (Blueprint $table) {

            $table->foreign('sekolah_id')->references('id')->on('mst_sekolah')->nullOnDelete();
            $table->foreign('wali_kelas_ptk_id')->references('id')->on('mst_gtk')->nullOnDelete();
            $table->foreign('semester_id')->references('id')->on('ref_semester')->nullOnDelete();
            $table->foreign('kurikulum_id')->references('id')->on('ref_kurikulum')->nullOnDelete();
        });

        Schema::table('mst_anggota_rombel', function (Blueprint $table) {
            $table->foreign('rombel_id')->references('id')->on('mst_rombel')->nullOnDelete();
            $table->foreign('peserta_didik_id')->references('id')->on('mst_peserta_didik')->nullOnDelete();
        });

        Schema::table('mst_pembelajaran', function (Blueprint $table) {
            $table->foreign('rombongan_belajar_id')->references('id')->on('mst_rombel')->nullOnDelete();
            $table->foreign('mata_pelajaran_id')->references('id')->on('ref_mapel')->nullOnDelete();
            $table->foreign('gtk_id')->references('id')->on('mst_gtk')->nullOnDelete();
            $table->foreign('semester_id')->references('id')->on('ref_semester')->nullOnDelete();
        });

        Schema::table('mst_sarpras_sekolah', function (Blueprint $table) {
            $table->foreign('sekolah_id')->references('id')->on('mst_sekolah')->nullOnDelete();
            $table->foreign('sarpras_id')->references('id')->on('ref_sarpras')->nullOnDelete();
        });

        Schema::table('mst_kondisi_sarpras', function (Blueprint $table) {
            $table->foreign('id_mst_sarpras')->references('id')->on('mst_sarpras_sekolah')->nullOnDelete();
        });

        Schema::table('ext_informasi', function (Blueprint $table) {
            $table->foreign('users_id')->references('id')->on('sys_users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('mst_sekolah', function (Blueprint $table) {
            $table->dropForeign(['kode_wilayah']);
            $table->dropForeign(['kode_jenjang']);
        });

        Schema::table('mst_gtk', function (Blueprint $table) {
            $table->dropForeign(['jenis_gtk']);
            $table->dropForeign(['tempat_tugas']);
        });

        Schema::table('mst_rombel', function (Blueprint $table) {
            $table->dropForeign(['sekolah_id']);
            $table->dropForeign(['wali_kelas_ptk_id']);
            $table->dropForeign(['semester_id']);
            $table->dropForeign(['kurikulum_id']);
        });

        Schema::table('mst_anggota_rombel', function (Blueprint $table) {
            $table->dropForeign(['rombel_id']);
            $table->dropForeign(['peserta_didik_id']);
            $table->dropForeign(['semester_id']);
        });

        Schema::table('mst_pembelajaran', function (Blueprint $table) {
            $table->dropForeign(['rombongan_belajar_id']);
            $table->dropForeign(['mata_pelajaran_id']);
            $table->dropForeign(['ptk_id']);
            $table->dropForeign(['semester_id']);
        });

        Schema::table('mst_sarpras_sekolah', function (Blueprint $table) {
            $table->dropForeign(['sekolah_id']);
            $table->dropForeign(['sarpras_id']);
        });

        Schema::table('ext_informasi', function (Blueprint $table) {
            $table->dropForeign(['users_id']);
        });

        Schema::table('mst_kondisi_sarpras', function (Blueprint $table) {
            $table->dropForeign(['id_mst_sarpras']);
        });
    }
};
