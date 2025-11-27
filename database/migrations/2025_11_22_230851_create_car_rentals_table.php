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
        Schema::create('car_rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('car_id')->constrained()->cascadeOnDelete();

            // Location
            $table->string('pickup_location');
            $table->string('dropoff_location')->nullable();
            $table->decimal('pickup_lat', 10, 7)->nullable();
            $table->decimal('pickup_lng', 10, 7)->nullable();
            $table->decimal('dropoff_lat', 10, 7)->nullable();
            $table->decimal('dropoff_lng', 10, 7)->nullable();

            // Time
            $table->dateTime('pickup_time');
            $table->dateTime('dropoff_time');

            // Pricing
            $table->decimal('price_per_hour', 10, 2)->nullable();
            $table->decimal('total_price', 10, 2)->nullable();

            // Plan
            $table->enum('plan_type', ['hourly', 'daily']);
            $table->integer('duration_hours')->nullable();
            $table->integer('duration_days')->nullable();

            // Statuses
            $table->enum('status', ['pending', 'confirmed', 'in_progress', 'completed', 'canceled'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'canceled', 'refunded'])->default('pending');
            $table->enum('payment_method', ['paypal','mastercard','visa','cash','stripe'])->nullable();

            $table->timestamp('payment_time')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_rentals');
    }
};
