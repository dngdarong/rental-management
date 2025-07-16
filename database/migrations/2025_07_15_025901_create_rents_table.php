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
        Schema::create('rents', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing

            // These single lines create the columns AND set up the foreign keys
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');

            $table->date('month'); // Store as YYYY-MM-01 to represent the month
            $table->decimal('amount', 8, 2); // The actual rent amount for that month
            $table->enum('status', ['Paid', 'Due', 'Partial'])->default('Due'); // Status of the rent
            $table->date('due_date'); // Due date for this rent record
            $table->timestamp('paid_at')->nullable(); // When the last payment for this rent record was made

            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rents');
    }
};

