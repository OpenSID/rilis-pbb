<?php

namespace Database\Factories;

use App\Models\Aplikasi;
use Illuminate\Database\Eloquent\Factories\Factory;

class AplikasiFactory extends Factory
{
    protected $model = Aplikasi::class;

    public function definition()
    {
        return [
            'key' => $this->faker->unique()->slug(),
            'value' => $this->faker->word(),
            'keterangan' => $this->faker->sentence(),
            'jenis' => $this->faker->randomElement(['text', 'password', 'number', 'email']),
            'kategori' => $this->faker->randomElement(['system', 'opensid', 'credential_layanan']),
            'script' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function opensidUrl()
    {
        return $this->state([
            'key' => 'opensid_url',
            'value' => 'https://api.test.opendesa.id',
            'keterangan' => 'URL server OpenSID',
            'jenis' => 'text',
            'kategori' => 'opensid',
        ]);
    }

    public function opensidEmail()
    {
        return $this->state([
            'key' => 'opensid_email',
            'value' => 'test@opendesa.id',
            'keterangan' => 'Email login OpenSID',
            'jenis' => 'email',
            'kategori' => 'opensid',
        ]);
    }

    public function opensidPassword()
    {
        return $this->state([
            'key' => 'opensid_password',
            'value' => 'testpassword',
            'keterangan' => 'Password login OpenSID',
            'jenis' => 'password',
            'kategori' => 'opensid',
        ]);
    }

    public function opensidToken()
    {
        return $this->state([
            'key' => 'opensid_token',
            'value' => '',
            'keterangan' => 'Token akses OpenSID',
            'jenis' => 'text',
            'kategori' => 'opensid',
        ]);
    }

    public function layananKodeDesa()
    {
        return $this->state([
            'key' => 'layanan_kode_desa',
            'value' => 'TEST_KODE_DESA',
            'keterangan' => 'Kode desa untuk layanan premium OpenDesa',
            'jenis' => 'text',
            'kategori' => 'credential_layanan',
        ]);
    }

    public function layananOpendosaToken()
    {
        return $this->state([
            'key' => 'layanan_opendesa_token',
            'value' => 'TEST_TOKEN_PREMIUM',
            'keterangan' => 'Token layanan premium OpenDesa',
            'jenis' => 'text',
            'kategori' => 'credential_layanan',
        ]);
    }

    public function empty()
    {
        return $this->state([
            'value' => '',
        ]);
    }

    public function withValue(string $value)
    {
        return $this->state([
            'value' => $value,
        ]);
    }
}
