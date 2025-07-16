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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing
            $table->string('room_number')->unique(); // Unique room number

            // This single line creates the 'room_type_id' column AND sets up the foreign key
            $table->foreignId('room_type_id')->constrained('room_types')->onDelete('cascade');

            $table->enum('status', ['available', 'occupied', 'under_maintenance'])->default('available'); // Status of the room
            $table->decimal('price', 8, 2); // Price of the room, allows overriding default from room_type

            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};

