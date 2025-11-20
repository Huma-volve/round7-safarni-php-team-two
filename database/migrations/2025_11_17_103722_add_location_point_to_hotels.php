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
   
        DB::statement('ALTER TABLE hotels ADD COLUMN location POINT NOT NULL DEFAULT POINT(0,0)');

    
        DB::statement('ALTER TABLE hotels ADD SPATIAL INDEX(location)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // حذف الـ index والعمود
        DB::statement('ALTER TABLE hotels DROP INDEX location');
        DB::statement('ALTER TABLE hotels DROP COLUMN location');
    }
};
