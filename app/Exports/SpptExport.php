<?php

namespace App\Exports;

use App\Http\Controllers\Transaksi\SpptController;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SpptExport implements FromView
{
    public function view(): View
    {
        $ambilData = new SpptController();
        $data = $ambilData->dataExport();

        return view('pages.transaksi.sppt._export-excel', [
            'sppts' => $data['rekaps'],
            'sebutan_rayon' => $data['sebutan_rayon']
        ]);
    }
}
