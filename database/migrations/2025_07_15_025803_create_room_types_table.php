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
        Schema::create('room_types', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing
            $table->string('name')->unique(); // <--- THIS IS THE CRUCIAL LINE for the 'name' column
            $table->text('description')->nullable(); // Description of the room type
            $table->decimal('default_price', 8, 2); // Default price for this room type

            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};

