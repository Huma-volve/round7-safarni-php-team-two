<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE cars ADD COLUMN city VARCHAR(255) null');
        DB::statement('ALTER TABLE tours ADD COLUMN city VARCHAR(255) null');
        DB::statement('ALTER TABLE hotels ADD COLUMN city VARCHAR(255) null');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE cars DROP COLUMN city');
        DB::statement('ALTER TABLE tours DROP COLUMN city');
        DB::statement('ALTER TABLE hotels DROP COLUMN city');
    }
};
