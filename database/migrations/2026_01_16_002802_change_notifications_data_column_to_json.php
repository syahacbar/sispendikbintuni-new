<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw SQL to alter column type with casting
        DB::statement('ALTER TABLE notifications ALTER COLUMN data TYPE JSON USING data::JSON');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE notifications ALTER COLUMN data TYPE TEXT');
    }
};
