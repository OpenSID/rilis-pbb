<?php

namespace Database\Seeders\Pengaturan;

use App\Models\Aplikasi;
use Illuminate\Database\Seeder;

class AplikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $aplikasi = array(
            ["key" => "kode_provinsi", "value" => "33", "keterangan" => "Isi 2 digit kode provinsi", "jenis" => "text", "kategori" => "pengaturan_wilayah", "script" => ""],
            ["key" => "nama_provinsi", "value" => "Jawa Tengah", "keterangan" => "Isi nama provinsi", "jenis" => "text", "kategori" => "pengaturan_wilayah", "script" => ""],
            ["key" => "kode_kabupaten", "value" => "03", "keterangan" => "Isi 2 digit kode kabupaten", "jenis" => "text", "kategori" => "pengaturan_wilayah", "script" => ""],
            ["key" => "nama_kabupaten", "value" => "Purbalingga", "keterangan" => "Isi nama kabupaten", "jenis" => "text", "kategori" => "pengaturan_wilayah", "script" => ""],
            ["key" => "kode_kecamatan", "value" => "150", "keterangan" => "Isi 2 digit kode kecamatan kemudian ditambahkan 0 di akhir", "jenis" => "text", "kategori" => "pengaturan_wilayah", "script" => ""],
            ["key" => "nama_kecamatan", "value" => "Padamara", "keterangan" => "Isi nama kecamatan", "jenis" => "text", "kategori" => "pengaturan_wilayah", "script" => ""],
            ["key" => "kode_desa", "value" => "004", "keterangan" => "Isi 2 digit kode desa kemudian ditambahkan 0 di awal", "jenis" => "text", "kategori" => "pengaturan_wilayah", "script" => ""],
            ["key" => "nama_desa", "value" => "Bojanegara", "keterangan" => "Isi nama desa", "jenis" => "text", "kategori" => "pengaturan_wilayah", "script" => ""],
            ["key" => "kaur_keuangan", "value" => "", "keterangan" => "Isi nama kaur keuangan", "jenis" => "text", "kategori" => "", "script" => ""],
            ["key" => "opensid_url", "value" => "", "keterangan" => "Isi url opensid", "jenis" => "text", "kategori" => "sinkronisasi_opensid", "script" => ""],
            ["key" => "opensid_email", "value" => "", "keterangan" => "Isi email opensid", "jenis" => "text", "kategori" => "sinkronisasi_opensid", "script" => ""],
            ["key" => "opensid_password", "value" => "", "keterangan" => "Isi kata sandi opensid", "jenis" => "text", "kategori" => "sinkronisasi_opensid", "script" => ""],
            ["key" => "opensid_token", "value" => "", "keterangan" => "Isi token opensid", "jenis" => "text", "kategori" => "sinkronisasi_opensid", "script" => ""],
            ["key" => "akun_pengguna", "value" => "", "keterangan" => "Pilih Akun Pengguna yang ditampilkan di navbar", "jenis" => "option", "kategori" => "", "script" => ""],
            ["key" => "latar_login", "value" => "", "keterangan" => "Kosongkan, jika latar login tidak berubah", "jenis" => "image", "kategori" => "latar_login", "script" => "previewLatarLogin()"],
            ["key" => "logo_aplikasi", "value" => "", "keterangan" => "Kosongkan, jika logo aplikasi tidak berubah", "jenis" => "image", "kategori" => "logo", "script" => "previewLogoAplikasi()"],
            ["key" => "logo_surat", "value" => "", "keterangan" => "Kosongkan, jika logo surat tidak berubah", "jenis" => "image", "kategori" => "logo", "script" => "previewLogoSurat()"],
            ["key" => "favicon", "value" => "", "keterangan" => "Kosongkan, jika favicon tidak berubah", "jenis" => "image", "kategori" => "logo", "script" => "previewLogoFavicon()"],
            ["key" => "sebutan_rayon", "value" => "Rayon", "keterangan" => "Pengganti sebutan rayon (contoh: kolektor/sub kolektor)", "jenis" => "text", "kategori" => "pengganti_sebutan", "script" => ""],
        );

        foreach ($aplikasi as $item) {
            Aplikasi::create($item);
        }
    }
}
