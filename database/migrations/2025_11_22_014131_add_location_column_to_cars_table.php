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
        DB::statement('ALTER TABLE cars ADD COLUMN location POINT NOT NULL');

        DB::statement('ALTER TABLE cars ADD SPATIAL INDEX idx_cars_location(location)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE cars DROP INDEX idx_cars_location');

        DB::statement('ALTER TABLE cars DROP COLUMN location');
    }
};
