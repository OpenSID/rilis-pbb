<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('pengaturan_aplikasi')
            ->whereIn('key', ['opensid_email', 'opensid_password'])
            ->delete();
            
        DB::table('pengaturan_aplikasi')
            ->where('key', 'opensid_token')
            ->update([
                'script' => null,
                'jenis' => 'textarea',
                'keterangan' => 'Isi token yang didapat dari OpenSID atau API Satu Data',
            ]);
            
        DB::table('pengaturan_aplikasi')
            ->where('key', 'layanan_opendesa_token')
            ->update([
                'jenis' => 'textarea',
            ]);
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
