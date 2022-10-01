<?php

namespace App\Imports;

use App\Models\ObjekPajak;
use App\Models\ObjekPajakDetail;
use App\Models\Periode;
use App\Models\RT;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SheetImportObjekBangunan implements ToModel, WithHeadingRow
{
    private $rts;
    private $objeks;
    private $details;
    private $periodes;

    public function __construct()
    {
        $this->rts = RT::get();
        $this->objeks = ObjekPajak::get();
        $this->details = ObjekPajakDetail::get();
        $this->periodes = Periode::get();
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $impor = null;
        $objek_bangunan = true;
        $rt = $this->rts->where('nama_rt', $row['nama_rt'])->first();
        $objek = $this->objeks->where('letak_objek', $row['letak_objek'])
            ->where('kode_blok', $row['kode_blok'])
            ->where('alamat_objek', $row['alamat_objek'])
            ->where('rt_id', $rt->id)
            ->first();
        $periode = $this->periodes->where('tahun', $row['periode'])->first();

        if (is_null($periode)) {
            return Session::flash('import-periode-failed', 'Gagal');
        }

        if (!is_null($periode)) {
            $objek_bangunan = $this->details->where('kategori', 2)
                ->where('luas_objek_pajak', $row['luas_objek_pajak_bangunan'])
                ->where('klas', $row['klas_bangunan'])
                ->where('njop', $row['njop_bangunan'])
                ->where('total_njop', $row['total_njop_bangunan'])
                ->where('periode_id', $periode->id)
                ->first();
        }

        if (!is_null($periode) && is_null($objek_bangunan) && $row['klas_bangunan'] != '') {
            $impor = $this->importTableObjekBangunan($row, $objek, $periode);
        }

        return $impor;
    }

    public function importTableObjekBangunan($row, $objek, $periode)
    {
        return new ObjekPajakDetail([
            'objek_pajak_id' => $objek->id ?? null,
            'kategori' => 2,
            'luas_objek_pajak' => $row['luas_objek_pajak_bangunan'],
            'klas' => $row['klas_bangunan'] ?? 0,
            'njop' => $row['njop_bangunan'],
            'total_njop' => $row['total_njop_bangunan'],
            'periode_id' => $periode->id ?? null,
        ]);
    }
}
