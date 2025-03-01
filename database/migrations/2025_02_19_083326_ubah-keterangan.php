<?php

use App\Models\Aplikasi;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Aplikasi::where(['key' => 'kode_kecamatan'])->update(['keterangan' => 'Kode Kecamatan menyesuaikan yang di SPPT']);
        
        Aplikasi::where(['key' => 'kode_desa'])->update(['keterangan' => 'Kode Desa menyesuaikan yang di SPPT']);
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
