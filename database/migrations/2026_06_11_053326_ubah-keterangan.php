<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        DB::table('pengaturan_aplikasi')
            ->where('key', 'kode_kecamatan')
            ->update(['keterangan' => 'Kode Kecamatan menyesuaikan yang di SPPT']);
        
        DB::table('pengaturan_aplikasi')
            ->where('key', 'kode_desa')
            ->update(['keterangan' => 'Kode Desa menyesuaikan yang di SPPT']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
