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
            $table->string('code')->unique(); // Código único do desconto
            $table->unsignedBigInteger('admin_id')->nullable(); // Para descontos criados pelo admin
            $table->unsignedBigInteger('user_id')->nullable();  // Para descontos atribuídos a usuários
            $table->enum('type', ['percentage', 'fixed']); // Tipo: porcentagem ou valor fixo
            $table->decimal('value', 10, 2); // Valor do desconto
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // Criado por (admin ou business)
            $table->foreignId('business_id')->nullable()->constrained('businesses')->onDelete('cascade'); // Relacionado a um negócio (opcional)
            $table->timestamp('expires_at')->nullable(); // Data de expiração
            $table->timestamp('applied_at')->nullable(); // Quando foi utilizado
            $table->foreignId('applied_to')->nullable()->constrained('bookings')->onDelete('cascade'); // Relacionado a uma reserva (opcional no futuro)
            $table->timestamps(); // Campos created_at e updated_at
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
