<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private $listTable = [
        'users',
        'model_has_roles',
        'model_has_permissions',
        'role_has_permissions',        
        'password_resets',
        'personal_access_tokens',
        'permissions',
        'roles',
        'pengaturan_aplikasi',
        'periode',
        'rt',
        'rayon',
        'subjek_pajak',
        'objek_pajak',
        'objek_pajak_detail',
        'sppt',
        'pembayaran',
        'otp_tokens',
    ];
    public function up(): void
    {
        $defaultTenantId = \Illuminate\Support\Facades\DB::table('tenants')->min('id');
        foreach ($this->listTable as $namaTable) {
            if (Schema::hasTable($namaTable)) {
                Schema::table($namaTable, function (Blueprint $table) use ($namaTable) {
                    if (!Schema::hasColumn($namaTable, 'tenant_id')) {
                        $table->unsignedBigInteger('tenant_id')->nullable();
                        $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');                        
                    }
                });                
            }
            // Update existing records to set tenant_id to default tenant
            if ($defaultTenantId) {
                \Illuminate\Support\Facades\DB::table($namaTable)->update(['tenant_id' => $defaultTenantId]);
            }
        }                
    }

    public function down(): void
    {
        foreach ($this->listTable as $namaTable) {
            if (Schema::hasTable($namaTable)) {
                Schema::table($namaTable, function (Blueprint $table) use ($namaTable) {
                    if (Schema::hasColumn($namaTable, 'tenant_id')) {
                        $table->dropForeign(['tenant_id']);
                        $table->dropColumn('tenant_id');
                    }
                });
            }
        }        
    }
};
