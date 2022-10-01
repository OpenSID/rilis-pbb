<?php

namespace App\Imports;

use App\Models\ObjekPajak;
use App\Models\ObjekPajakDetail;
use App\Models\Periode;
use App\Models\RT;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Session;

class SheetImportObjekBumi implements ToModel, WithHeadingRow
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
        $objek_bumi = true;
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
            $objek_bumi = $this->details->where('kategori', 1)
                ->where('luas_objek_pajak', $row['luas_objek_pajak_bumi'])
                ->where('klas', $row['klas_bumi'])
                ->where('njop', $row['njop_bumi'])
                ->where('total_njop', $row['total_njop_bumi'])
                ->where('periode_id', $periode->id)
                ->first();
        }

        if (!is_null($periode) && is_null($objek_bumi) && $row['klas_bumi'] != '') {
            $impor = $this->importTableObjekBumi($row, $objek, $periode);
        }

        return $impor;
    }

    public function importTableObjekBumi($row, $objek, $periode)
    {
        return new ObjekPajakDetail([
            'objek_pajak_id' => $objek->id ?? null,
            'kategori' => 1,
            'luas_objek_pajak' => $row['luas_objek_pajak_bumi'],
            'klas' => $row['klas_bumi'] ?? 0,
            'njop' => $row['njop_bumi'],
            'total_njop' => $row['total_njop_bumi'],
            'periode_id' => $periode->id ?? null,
        ]);
    }
}
