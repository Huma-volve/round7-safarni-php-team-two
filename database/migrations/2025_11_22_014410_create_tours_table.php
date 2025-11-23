<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->float('rating')->default(0);
            $table->string('image')->nullable();

            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamps();
        });

        // Add POINT column for location
        DB::statement('ALTER TABLE tours ADD COLUMN location POINT NOT NULL');

        // Add SPATIAL index for fast geolocation search
        DB::statement('ALTER TABLE tours ADD SPATIAL INDEX idx_tours_location(location)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the spatial index first
        DB::statement('ALTER TABLE tours DROP INDEX idx_tours_location');
        Schema::dropIfExists('tours');
    }
};
