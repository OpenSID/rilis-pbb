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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('twofa_enabled')->default(false);
            $table->string('twofa_method')->nullable(); // email or telegram
            $table->string('twofa_contact')->nullable(); // email address or telegram chat id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['twofa_enabled', 'twofa_method', 'twofa_contact']);
        });
    }
};