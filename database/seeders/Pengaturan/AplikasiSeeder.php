<?php

namespace Database\Seeders\Pengaturan;

use App\Models\Aplikasi;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AplikasiSeeder extends Seeder
{
    public const KODE_DESA = "004";
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        // kalau posisi install awal, artinya pasti hanya ada 1 tenant
        $tenant = Tenant::first();
        $tenantId = $tenant->id;
        $kodeDesa = self::KODE_DESA;
        $aplikasi = array(
            ["tenant_id" => $tenantId, "created_at" => Carbon::now(),  "updated_at" => Carbon::now(), "key" => "kode_provinsi", "value" => "33", "keterangan" => "Isi 2 digit kode provinsi", "jenis" => "text", "kategori" => "pengaturan_wilayah", "script" => ""],
            ["tenant_id" => $tenantId, "created_at" => Carbon::now(),  "updated_at" => Carbon::now(), "key" => "nama_provinsi", "value" => "Jawa Tengah", "keterangan" => "Isi nama provinsi", "jenis" => "text", "kategori" => "pengaturan_wilayah", "script" => ""],
            ["tenant_id" => $tenantId, "created_at" => Carbon::now(),  "updated_at" => Carbon::now(), "key" => "kode_kabupaten", "value" => "03", "keterangan" => "Isi 2 digit kode kabupaten", "jenis" => "text", "kategori" => "pengaturan_wilayah", "script" => ""],
            ["tenant_id" => $tenantId, "created_at" => Carbon::now(),  "updated_at" => Carbon::now(), "key" => "nama_kabupaten", "value" => "Purbalingga", "keterangan" => "Isi nama kabupaten", "jenis" => "text", "kategori" => "pengaturan_wilayah", "script" => ""],
            ["tenant_id" => $tenantId, "created_at" => Carbon::now(),  "updated_at" => Carbon::now(), "key" => "kode_kecamatan", "value" => "150", "keterangan" => "Isi 2 digit kode kecamatan kemudian ditambahkan 0 di akhir", "jenis" => "text", "kategori" => "pengaturan_wilayah", "script" => ""],
            ["tenant_id" => $tenantId, "created_at" => Carbon::now(),  "updated_at" => Carbon::now(), "key" => "nama_kecamatan", "value" => "Padamara", "keterangan" => "Isi nama kecamatan", "jenis" => "text", "kategori" => "pengaturan_wilayah", "script" => ""],
            ["tenant_id" => $tenantId, "created_at" => Carbon::now(),  "updated_at" => Carbon::now(), "key" => "kode_desa", "value" => $kodeDesa, "keterangan" => "Isi 2 digit kode desa kemudian ditambahkan 0 di awal", "jenis" => "text", "kategori" => "pengaturan_wilayah", "script" => ""],
            ["tenant_id" => $tenantId, "created_at" => Carbon::now(),  "updated_at" => Carbon::now(), "key" => "nama_desa", "value" => "Bojanegara", "keterangan" => "Isi nama desa", "jenis" => "text", "kategori" => "pengaturan_wilayah", "script" => ""],
            ["tenant_id" => $tenantId, "created_at" => Carbon::now(),  "updated_at" => Carbon::now(), "key" => "kaur_keuangan", "value" => "", "keterangan" => "Isi nama kaur keuangan", "jenis" => "text", "kategori" => "", "script" => ""],
            ["tenant_id" => $tenantId, "created_at" => Carbon::now(),  "updated_at" => Carbon::now(), "key" => "opensid_url", "value" => "", "keterangan" => "Isi url opensid", "jenis" => "text", "kategori" => "sinkronisasi_opensid", "script" => ""],
            ["tenant_id" => $tenantId, "created_at" => Carbon::now(),  "updated_at" => Carbon::now(), "key" => "opensid_token", "value" => "", "keterangan" => "Isi token opensid", "jenis" => "text", "kategori" => "sinkronisasi_opensid", "script" => ""],
            ["tenant_id" => $tenantId, "created_at" => Carbon::now(),  "updated_at" => Carbon::now(), "key" => "akun_pengguna", "value" => "", "keterangan" => "Pilih Akun Pengguna yang ditampilkan di navbar", "jenis" => "option", "kategori" => "", "script" => ""],
            ["tenant_id" => $tenantId, "created_at" => Carbon::now(),  "updated_at" => Carbon::now(), "key" => "latar_login", "value" => "", "keterangan" => "Kosongkan, jika latar login tidak berubah", "jenis" => "image", "kategori" => "latar_login", "script" => "previewLatarLogin()"],
            ["tenant_id" => $tenantId, "created_at" => Carbon::now(),  "updated_at" => Carbon::now(), "key" => "logo_aplikasi", "value" => "", "keterangan" => "Kosongkan, jika logo aplikasi tidak berubah", "jenis" => "image", "kategori" => "logo", "script" => "previewLogoAplikasi()"],
            ["tenant_id" => $tenantId, "created_at" => Carbon::now(),  "updated_at" => Carbon::now(), "key" => "logo_surat", "value" => "", "keterangan" => "Kosongkan, jika logo surat tidak berubah", "jenis" => "image", "kategori" => "logo", "script" => "previewLogoSurat()"],
            ["tenant_id" => $tenantId, "created_at" => Carbon::now(),  "updated_at" => Carbon::now(), "key" => "favicon", "value" => "", "keterangan" => "Kosongkan, jika favicon tidak berubah", "jenis" => "image", "kategori" => "logo", "script" => "previewLogoFavicon()"],
            ["tenant_id" => $tenantId, "created_at" => Carbon::now(),  "updated_at" => Carbon::now(), "key" => "sebutan_rayon", "value" => "Rayon", "keterangan" => "Pengganti sebutan rayon (contoh: kolektor/sub kolektor)", "jenis" => "text", "kategori" => "pengganti_sebutan", "script" => ""],
        );
        $tablePengaturan = (new Aplikasi)->getTable();
        DB::table($tablePengaturan)->insert($aplikasi);

        // update nilai layanan_kode_desa jika masih kosong
        $layananKodeDesa = DB::table($tablePengaturan)->where('key','layanan_kode_desa')->first();
        if(!$layananKodeDesa->value){            
            DB::table($tablePengaturan)->where('key','layanan_kode_desa')->update(['value' => $kodeDesa]);
        }
    }
}
