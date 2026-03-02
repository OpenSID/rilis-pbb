<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait DataOpensid
{
    public function ambilDataOpensid($endpoint)
    {
        $setting = \App\Models\Aplikasi::whereIn('key', ['opensid_token', 'opensid_url'])->pluck('value', 'key')->toArray();
        $token = $setting['opensid_token'] ?? null;
        $url = $setting['opensid_url'] ?? '';
        $url .= $endpoint;
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
                'Accept' => 'application/json',
            ])->withoutVerifying()
                ->get($url);
            // Pastikan API merespons dengan kode status yang sesuai
            if ($response->getStatusCode() == 200) {
                return $response->json();
            } else {
                Log::error('Request to OpenSID API', ['response' => $response->body()]);
                session()->flash('message-periksa', 'Terjadi kesalahan pada server, silakan coba lagi.');
            }
        } catch (Exception $e) {
            // Tangani kesalahan API dengan baik
            session()->flash('message-periksa', 'Silakan Periksa sinkronisasi ke OpenSID melalui API pada halaman');
            Log::error('Response from OpenSID API: ' . $e->getMessage());
        }

        return null;
    }

    public function ambilTokenOpensid($url, $username, $password)
    {
        try {
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Accept' => 'application/json',
                    'X-AUTH-GUARD' => 'admin'
                ])
                ->post($url . '/api/v1/auth/login', [
                    'credential' => $username,
                    'password' => $password
                ]);

            if ($response->getStatusCode() == 200) {
                $result = json_decode($response->getBody());
                $token = $result->data->attributes->access_token->token;
                return $token ?? null;
            } else {
                Log::error('Authentication to OpenSID API', ['response' => $response->body()]);
                session()->flash('message-failed', 'Gagal autentikasi ke OpenSID. Periksa URL, username, dan password.');
            }
        } catch (Exception $e) {
            session()->flash('message-failed', 'Terjadi kesalahan saat menghubungi OpenSID API.');
            Log::error('Authentication to OpenSID API: ' . $e->getMessage());
        }

        return null;
    }
}
