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
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('flight_number');
            $table->foreignId('carrier_id')->constrained('carriers');
            $table->foreignId('origin_airport_id')->constrained('airports');
            $table->foreignId('dest_airport_id')->constrained('airports');
            $table->dateTime('departure_at');
            $table->dateTime('arrival_at');
            $table->string('duration');
            $table->tinyInteger('status')->default(1)
                ->comment('0: Cancelled, 1: Scheduled, 2: Delayed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
