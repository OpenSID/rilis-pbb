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
                'Authorization' => "Bearer {$token}"
            ])->get($url);
            // Pastikan API merespons dengan kode status yang sesuai
            if ($response->getStatusCode() == 200) {
                return $response->json();
            } elseif ($response->getStatusCode() == 500) {
                session()->flash('message-periksa', 'Terjadi kesalahan pada server, silakan coba lagi.');
            }
        } catch (Exception $e) {
            // Tangani kesalahan API dengan baik
            session()->flash('message-periksa', 'Silakan Periksa sinkronisasi ke OpenSID melalui API pada halaman');
            Log::error('Response from OpenSID API: ' . $e->getMessage());
        }

        return null;
    }
}
