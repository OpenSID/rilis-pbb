<?php

namespace App\Console\Commands\AppMigrations;

use App\Http\Controllers\Controller;
use App\Models\Aplikasi;
use Symfony\Component\Process\Process;

class Migrasi_221101 extends Controller
{
    public function migrasi()
    {
        $hasil = true;

        // Jalankan migrasi sebelumnya
        $hasil = $hasil && $this->migrasi_database($hasil);

        return $hasil && $this->migrasi_2022102001($hasil);
    }

    public function migrasi_database($hasil)
    {
        $migrate = new Process(['php', 'artisan', 'migrate'], base_path());
        $migrate->setTimeout(null);
        $migrate->run();

        var_dump('migrasi_database');
        return $hasil;
    }

    public function migrasi_2022102001($hasil)
    {
        $aplikasi = Aplikasi::get();
        $url = $aplikasi->where('key', 'opensid_url')->first();
        if (!is_null($url)) {
            $url->keterangan = 'Isi url OpenSID API';
            $url->save();
        }

        $url = $aplikasi->where('key', 'opensid_email')->first();
        if (!is_null($url)) {
            $url->keterangan = 'Isi email OpenSID';
            $url->save();
        }

        $password = $aplikasi->where('key', 'opensid_password')->first();
        if (!is_null($password)) {
            $password->script = 'password';
            $url->keterangan = 'Isi kata sandi OpenSID';
            $password->save();
        }

        $token = $aplikasi->where('key', 'opensid_token')->first();
        if (!is_null($token)) {
            $token->script = 'disabled';
            $token->keterangan = 'token akan terisi otomatis';
            $token->save();
        }

        var_dump('migrasi_2022102001');
        return $hasil;
    }
}
