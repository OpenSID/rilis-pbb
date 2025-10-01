<?php

use App\Models\Aplikasi;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Aplikasi::whereIn('key', ['opensid_email', 'opensid_password'])->delete();
        Aplikasi::where('key', 'opensid_token')->update([
            'script' => null,
            'jenis' => 'textarea',
            'keterangan' => 'Isi token yang didapat dari OpenSID atau API Satu Data',
        ]);
        Aplikasi::where('key', 'layanan_opendesa_token')->update([
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
