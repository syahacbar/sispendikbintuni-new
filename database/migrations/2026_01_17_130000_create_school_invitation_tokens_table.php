<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('school_invitation_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('token', 32)->unique();
            $table->string('npsn', 8)->index();
            $table->string('email')->nullable();
            $table->timestamp('expires_at');
            $table->timestamp('used_at')->nullable();
            $table->foreignId('used_by_user_id')->nullable()->constrained('sys_users')->onDelete('set null');
            $table->foreignId('created_by_user_id')->constrained('sys_users')->onDelete('cascade');
            $table->timestamps();

            // Index untuk query performa
            $table->index(['token', 'expires_at']);
            $table->index(['npsn', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_invitation_tokens');
    }
};
