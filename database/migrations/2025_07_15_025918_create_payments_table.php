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
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing
            $table->foreignId('rent_id')->nullable()->constrained('rents')->onDelete('set null'); // Foreign key to rents table, nullable
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade'); // Foreign key to tenants table

            $table->decimal('amount', 8, 2); // <--- THIS IS THE CRUCIAL LINE for the 'amount' column
            $table->string('payment_method'); // e.g., 'Cash', 'Bank Transfer', 'Online Payment'
            $table->timestamp('payment_date'); // Date and time of payment
            $table->text('notes')->nullable(); // Optional notes for the payment

            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

