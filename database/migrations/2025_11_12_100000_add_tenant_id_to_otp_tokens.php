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
        $defaultTenantId = \Illuminate\Support\Facades\DB::table('tenants')->min('id');
        
        if (Schema::hasTable('otp_tokens')) {
            Schema::table('otp_tokens', function (Blueprint $table) {
                if (!Schema::hasColumn('otp_tokens', 'tenant_id')) {
                    $table->unsignedBigInteger('tenant_id')->nullable()->after('id');
                    $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
                }
            });
            
            // Update existing records to set tenant_id to default tenant
            if ($defaultTenantId) {
                \Illuminate\Support\Facades\DB::table('otp_tokens')->update(['tenant_id' => $defaultTenantId]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('otp_tokens')) {
            Schema::table('otp_tokens', function (Blueprint $table) {
                if (Schema::hasColumn('otp_tokens', 'tenant_id')) {
                    $table->dropForeign(['tenant_id']);
                    $table->dropColumn('tenant_id');
                }
            });
        }
    }
};
