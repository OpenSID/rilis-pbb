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
        // Remove the existing unique constraint on username
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']); // This removes the unique constraint on username only
            $table->dropUnique(['email']); // This removes the unique constraint on username only
        });
        
        // Add a unique constraint on the combination of username and tenant_id
        Schema::table('users', function (Blueprint $table) {
            $table->unique(['username', 'tenant_id'], 'users_username_tenant_id_unique');
            $table->unique(['email', 'tenant_id'], 'users_email_tenant_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the unique constraint on username and tenant_id combination
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_username_tenant_id_unique');
            $table->dropUnique('users_email_tenant_id_unique');
        });
        
        // Restore the unique constraint on username only
        Schema::table('users', function (Blueprint $table) {
            $table->unique(['username']);
            $table->unique(columns: ['email']);
        });
    }
};
