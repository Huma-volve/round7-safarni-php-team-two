<?php

use App\Models\FareRules;
use App\Models\Flight;
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
        Schema::create('flight_fares', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Flight::class)->constrained('flights')->cascadeOnDelete();
            $table->foreignIdFor(FareRules::class)->constrained('fare_rules')->cascadeOnDelete();
            $table->string('cabin_class');
            $table->decimal('price', 10, 2);
            $table->integer('seats_left');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_fares');
    }
};
