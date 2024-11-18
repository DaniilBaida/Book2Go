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
            $table->foreignId('booking_id')->constrained()->onDelete('cascade'); // Link to booking
            $table->unsignedTinyInteger('rating');   // Rating between 1 and 5
            $table->text('comment')->nullable();     // Optional review comment
            $table->enum('reviewer_type', ['client', 'business']); // Who wrote the review
            $table->boolean('is_approved')->default(false); // Admin approval flag
            $table->timestamp('reported_at')->nullable();
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
