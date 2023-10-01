<?php

namespace App\Policies;

use App\Models\Aplikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Csp\Policies\Basic;
use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Symfony\Component\HttpFoundation\Response;

class CustomCSPPolicy extends Basic
{
    // exclude karena livewire tidak jalan ketika csp enable
    private $excludeRoute = ['cetak-rekap.index', 'aplikasi.index', 'objek-pajak.create', 'rekap-lunas.index'];
    // contoh generate sha256 nama function
    // echo -n 'showBatalBayarModal(this)' | openssl sha256 -binary | openssl base64
    public function configure()
    {
        parent::configure();
        $opensidUrl = Aplikasi::where(['key' => 'opensid_url'])->first()?->value;
        $this->addDirective(Directive::IMG, ['data:;'])
        ->addDirective(Directive::STYLE, [
            'sha256-47DEQpj8HBSa+/TImW+5JCeuQeRkm5NMpJWZG3hSuFU=',
            'sha256-9DoVum3m8JKsIY3DTlnlYUaZmF0qX8+iPcNp2w20t90=',
            'sha256-TsVIN7SQps98aly1gmseL0Zta8mas2ihwfacnZ8U8oc=',
            'https://fonts.googleapis.com/',
        ])->addDirective(Directive::SCRIPT, [
            'https://cdn.jsdelivr.net'

        ])->addDirective(Directive::FONT, [
            Keyword::SELF,
            'https://fonts.gstatic.com/'
        ])->addDirective(Directive::CONNECT, [
            $opensidUrl
        ]);
    }

    public function shouldBeApplied(Request  $request, Response $response): bool
    {
        $currentRoute = Route::getCurrentRoute()->getName();

        if (in_array($currentRoute, $this->excludeRoute)) {
            config(['csp.enabled' => false]);
        }

        return config('csp.enabled');
    }
}
