<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        DB::statement('ALTER TABLE hotels ADD COLUMN location POINT NOT NULL');


        DB::statement('ALTER TABLE hotels ADD SPATIAL INDEX idx_location(location)');

        DB::statement("UPDATE hotels SET location = ST_PointFromText('POINT(0 0)')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Drop the spatial index
        DB::statement('ALTER TABLE hotels DROP INDEX idx_location');
        // Drop the column
        DB::statement('ALTER TABLE hotels DROP COLUMN location');
    }
};
