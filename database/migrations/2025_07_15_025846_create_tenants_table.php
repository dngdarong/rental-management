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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing
            $table->string('full_name');
            $table->string('email')->unique()->nullable(); // Email can be unique or null
            $table->string('phone')->unique(); // Phone should be unique
            $table->string('address')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();

            // This single line creates the 'room_id' column AND sets up the foreign key
            // It's nullable because a tenant might be registered before being assigned a room
            $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('set null');

            $table->date('start_date'); // Date when the tenant started
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};

