<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    private function getData()
    {
        $data = [
            ["key" => "layanan_opendesa_token", "value" => env('TOKEN_PREMIUM'), "keterangan" => "Token layanan premium OpenSID untuk cek validitas ke Layanan OpenDesa", "jenis" => "text", "kategori" => "credential_layanan", "script" => ""],
            ["key" => "layanan_kode_desa", "value" => env('KODE_DESA'), "keterangan" => "Kode desa untuk cek validitas ke Layanan OpenDesa", "jenis" => "text", "kategori" => "credential_layanan", "script" => ""],
        ];
        return $data;
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->getData() as $item) {
            if (!DB::table('pengaturan_aplikasi')->where('key', $item['key'])->exists()) {
                DB::table('pengaturan_aplikasi')->insert($item);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->getData() as $item) {
            DB::table('pengaturan_aplikasi')->where('key', $item['key'])->delete();
        }
    }
};
