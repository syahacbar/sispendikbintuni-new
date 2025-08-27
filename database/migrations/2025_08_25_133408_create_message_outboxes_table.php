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
        Schema::create('message_outboxes', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('recipient_name')->nullable();
            $table->string('recipient_number');
            $table->text('message');
            $table->string('status')->default('queued'); // queued|sent|failed
            $table->string('provider_message_id')->nullable();
            $table->json('provider_raw')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_outboxes');
    }
};
