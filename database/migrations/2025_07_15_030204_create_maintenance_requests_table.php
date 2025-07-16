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
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->onDelete('set null'); // Foreign key to tenants table, nullable if admin submits
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade'); // Foreign key to rooms table

            $table->string('title'); // Title of the maintenance request
            $table->text('description'); // Detailed description of the request
            $table->enum('status', ['Pending', 'In Progress', 'Completed', 'Cancelled'])->default('Pending'); // Status of the request
            $table->timestamp('reported_at')->useCurrent(); // When the request was reported
            $table->timestamp('completed_at')->nullable(); // When the request was completed
            $table->text('notes')->nullable(); // Admin notes regarding the request

            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};

