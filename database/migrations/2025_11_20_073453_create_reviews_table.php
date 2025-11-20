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
        Schema::create('reviews', function (Blueprint $table) {
          $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Polymorphic
            $table->morphs('reviewable'); 
        // reviewable_id + reviewable_type

            $table->tinyInteger('rating'); 
            $table->string('title')->nullable();
            $table->text('body');
            $table->json('photos')->nullable();

        
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
