<?php

use App\Models\Business;
use App\Models\ServiceCategory;
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
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->text('description')->nullable();
            $table->integer('duration_minutes');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('image_path')->nullable();
            $table->jsonb('tags')->nullable();
            $table->unsignedBigInteger('bookings_count')->default(0);
            $table->enum('status', ['active', 'inactive', 'archived'])->default('active');
            $table->foreignIdFor(Business::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(ServiceCategory::class)->constrained()->onDelete('cascade');
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
