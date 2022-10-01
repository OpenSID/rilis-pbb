<?php

namespace App\Console\Commands\AppMigrations;

use App\Http\Controllers\Controller;
use App\Models\Aplikasi;
use Symfony\Component\Process\Process;

class Migrasi_221001 extends Controller
{
    public function migrasi()
    {
        $hasil = true;

        // Jalankan migrasi sebelumnya
        $hasil = $hasil && $this->migrasi_database($hasil);
        $hasil = $hasil && $this->migrasi_2022091901($hasil);

        return $hasil && $this->migrasi_2022091902($hasil);
    }

    public function migrasi_database($hasil)
    {
        $migrate = new Process(['php', 'artisan', 'migrate'], base_path());
        $migrate->setTimeout(null);
        $migrate->run();

        var_dump('migrasi_database');
        return $hasil;
    }

    public function migrasi_2022091901($hasil)
    {
        $aplikasi = Aplikasi::where('key', 'nama_bendahara')->first();
        if (!is_null($aplikasi)) {
            $aplikasi->key = 'kaur_keuangan';
            $aplikasi->keterangan = 'Isi nama kaur keuangan';
            $aplikasi->kategori = 'pengaturan_wilayah';
            $aplikasi->save();
        }

        var_dump('migrasi_2022091901');
        return $hasil;
    }

    public function migrasi_2022091902($hasil)
    {
        $aplikasi = Aplikasi::where('key', 'sebutan_rayon')->first();
        if (is_null($aplikasi)) {
            $attributes = [
                'key' => 'sebutan_rayon',
                'value' => 'Rayon',
                'keterangan' => 'Pengganti sebutan rayon (contoh: kolektor/sub kolektor)',
                'jenis' => 'text',
                'kategori' => 'pengganti_sebutan',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            Aplikasi::create($attributes);
        }

        var_dump('migrasi_2022091902');
        return $hasil;
    }
}
