<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Unique discount code
            $table->string('type'); // Discount type (percentage, fixed)
            $table->decimal('value', 15, 8); // Discount value
            $table->unsignedInteger('max_uses')->nullable(); // Maximum number of uses
            $table->unsignedInteger('uses')->default(0); // Current usage count
            $table->enum('status', ['active', 'used', 'expired'])->default('active'); // Discount status
            $table->foreignIdFor(\App\Models\User::class, 'admin_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Business::class)->nullable()->constrained()->cascadeOnDelete(); // Permitir NULL
            $table->foreignIdFor(\App\Models\Service::class)->nullable()->constrained()->cascadeOnDelete(); // Optional service-specific discount
            $table->foreignIdFor(\App\Models\User::class, 'used_by')->nullable()->constrained()->nullOnDelete(); // Client who used the discount
            $table->timestamp('expires_at')->nullable(); // Expiry date
            $table->timestamp('applied_at')->nullable(); // When the discount was used
            $table->foreignIdFor(\App\Models\Booking::class)->nullable()->constrained()->cascadeOnDelete(); // Booking reference
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_codes');
    }
};
