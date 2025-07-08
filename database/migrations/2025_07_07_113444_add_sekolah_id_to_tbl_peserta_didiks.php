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
        Schema::table('tbl_peserta_didiks', function (Blueprint $table) {
            $table->foreign('sekolah_id')
                ->references('id')->on('tbl_sekolahs')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_peserta_didiks', function (Blueprint $table) {
            $table->dropForeign(['sekolah_id']);
        });
    }
};
