<?php

namespace App\Console\Commands;

use App\Console\Commands\AppMigrations\Migrasi_221001;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Process\Process;

class AppMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pbb:migrate {--db=} {--migrasi=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrasi database secara otomatis jika tambah versi';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->files = new Filesystem();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $db = $this->option('db');
        $migrasi = $this->option('migrasi');
        $versi = $this->cekVersi();

        if (($versi['version_app'] < $versi['version_tags'])) {
            // config DB_MIGRATE menjadi false || dijalankan ketika versi aplikasi lurang dari aplikasi
            $this->db_migrate('true', 'false');
        } else if ($db == 'true' && $migrasi == 'mulai') {
            // dijalankan untuk melakukan migrasi secara manual
            $this->startMigrate();
        } else if ($db == 'true' && env('DB_MIGRATE') == true) {
            // config DB_MIGRATE menjadi false || dijalankan manual untuk mengubah statusnya
            $this->db_migrate('true', 'false');
        } else if (($versi['version_app'] == $versi['version_tags']) && (env('DB_MIGRATE') == false)) {
            // dijalankan ketika versi aplikasi dan DB_MIGRATE false || dapat dijalankan migrasi menggunakan cronjob
            $this->startMigrate();
        } else {
            // pesan jika gagal
            var_dump('Status: tidak berhasil melakukan migrasi');
        }
    }

    // jika ada perubahan migrasi makda ubahlah pada method ini
    private function startMigrate()
    {
        $migrasi = new Migrasi_221001;
        $migrasi->migrasi();

        // config DB_MIGRATE menjadi true
        $this->db_migrate('false', 'true');
    }

    //method untuk cek versi aplikasi dengan repo rilis terbaru
    private function cekVersi()
    {
        //cek rilis terbaru tanpa token
        $response = Http::withHeaders([
            'Accept' => 'application/vnd.github.v3+json',
            'Authorization' => ""
        ])->get('https://api.github.com/repos/OpenSID/rilis-pbb/releases/latest')->throw()->json();
        $version_tags = preg_replace('/[^0-9]/', '', $response['tag_name']);

        $path_root = base_path();
        $content_versi = 0;
        if (File::exists($path_root . DIRECTORY_SEPARATOR . 'artisan')) {
            $artisan = new Process(['php', $path_root . DIRECTORY_SEPARATOR . 'artisan', 'app:version']);
            $artisan->run();
            $content_versi = $artisan->getOutput();
        }

        $version_app = preg_replace('/[^0-9]/', '', $content_versi);

        $versi = ['version_tags' => $version_tags, 'version_app' => $version_app];
        return $versi;
    }

    // method untuk merubah status DB_MIGRATE
    private function db_migrate($old, $new)
    {
        $env = base_path() . DIRECTORY_SEPARATOR . '.env';

        $configEnv = $this->files->get($env);
        $content = str_replace(['DB_MIGRATE=' . $old], ['DB_MIGRATE=' . $new], $configEnv);
        $replace = $this->files->replace($env, $content);

        $status = '';
        if ($new == 'true') {
            $status = 'berhasil melakukan migrasi';
        } else {
            $status = 'tidak berhasil melakukan migrasi';
        }

        var_dump('Status:' . $status);
        return $replace;
    }
}
