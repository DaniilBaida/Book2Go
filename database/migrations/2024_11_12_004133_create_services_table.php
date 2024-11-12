<?php

use App\Models\Business;
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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            // Service Details
            $table->string('name'); // Custom service name
            $table->decimal('price', 8, 2); // Price for the service
            $table->text('description')->nullable(); // Details about the service

            $table->decimal('original_price', 8, 2)->nullable(); // For discount reference
            $table->decimal('discount_price', 8, 2)->nullable();
            $table->dateTime('discount_start_date')->nullable();
            $table->dateTime('discount_end_date')->nullable();

            $table->integer('duration_minutes'); // Duration of service in minutes

            $table->jsonb('availability')->nullable(); // Available time slots (JSON format)

            $table->string('image_path')->nullable(); // Service image path

            $table->decimal('average_rating', 2, 1)->default(0); // Service rating (default 0)
            $table->unsignedBigInteger('reviews_count')->default(0); // Total number of reviews

            $table->integer('max_capacity')->nullable(); // For group service bookings

            $table->jsonb('tags')->nullable(); // Keywords/tags for services

            $table->unsignedBigInteger('bookings_count')->default(0); // Track popularity

            $table->enum('status', ['active', 'inactive', 'archived'])->default('active'); // Service status

            $table->foreignIdFor(Business::class)->constrained()->onDelete('cascade');
            $table->foreignId('service_category_id')->constrained('service_categories')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
