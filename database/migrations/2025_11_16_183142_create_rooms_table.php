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
        Schema::create('rooms', function (Blueprint $table) {
         $table->id();

            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');

            $table->string('name');
            $table->text('description')->nullable();

            // Images
            $table->string('main_image')->nullable();
            $table->json('photos')->nullable();

            // Occupancy
            $table->json('occupancy')->nullable(); 
            // example: { "adults": 2, "children": 1, "infants": 1 }

            $table->string('bed_type')->nullable();
            $table->integer('room_area')->nullable(); // e.g., 35 sqm

            // Pricing
            $table->decimal('price_per_night', 10, 2);
            $table->json('seasonal_pricing')->nullable(); 
            // example: { "2025-06": 120, "2025-07": 140 }

        
            $table->json('availability_calendar')->nullable();
            // example: { "2025-06-10": false, "2025-06-11": true }

            $table->boolean('refundable')->default(true);

            $table->json('extras')->nullable(); 
          

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
