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
        Schema::create('sys_settings', function (Blueprint $table) {
            $table->id();
            $table->string('group')->nullable();           // Contoh: api, smtp, payment
            $table->string('key')->unique()->nullable();               // Contoh: api.google_maps_key
            $table->text('value')->nullable();             // Nilai setting
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_settings');
    }
};
