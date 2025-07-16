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
        Schema::table('users', function (Blueprint $table) {
            // Add a 'role' column with default 'admin_tenant'
            // Using enum for predefined roles is good practice
            $table->enum('role', ['super_admin', 'admin_tenant'])->default('admin_tenant')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the 'role' column if rolling back the migration
            $table->dropColumn('role');
        });
    }
};

