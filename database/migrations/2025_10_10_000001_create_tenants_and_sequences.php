<?php

use Database\Seeders\Pengaturan\AplikasiSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->bigInteger('id_start_range')->unsigned();
            $table->bigInteger('id_end_range')->unsigned();
            $table->timestamps();
        });                
        
        $desa = DB::table('pengaturan_aplikasi')
            ->where('key', 'nama_desa')
            ->first();
        $kode = DB::table('pengaturan_aplikasi')
            ->where('key', 'layanan_kode_desa')
            ->first();
        // Provide default values if pengaturan_aplikasi is empty
        if (!$desa) {
            $desa = (object)['value' => 'Desa Default'];
        }
        if (!$kode) {
            $kode = (object)['value' => 'KODEDEFAULT'];
        }
        if ($desa && $kode) {
            DB::table('tenants')->insert([
                'code' => $kode->value ?: AplikasiSeeder::KODE_DESA,
                'name' => $desa->value,
                'id_start_range' => 1,
                'id_end_range' => 999999999,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }    

    public function down()
    {
        Schema::dropIfExists('tenants');
    }
};
