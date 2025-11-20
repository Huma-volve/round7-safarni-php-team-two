<?php

use App\Models\Flight;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flight_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->cascadeOnDelete();
            $table->foreignIdFor(Flight::class)->constrained('flights')->cascadeOnDelete();

            $table->unsignedBigInteger('item_id');
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending');
            $table->string('payment_status')->default('pending');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
