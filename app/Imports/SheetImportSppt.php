<?php

namespace App\Imports;

use App\Models\ObjekPajak;
use App\Models\Periode;
use App\Models\Sppt;
use App\Models\SubjekPajak;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SheetImportSppt implements ToModel, WithHeadingRow
{
    private $objeks;
    private $subjeks;
    private $periodes;
    private $status;
    private $sppts;

    public function __construct()
    {
        $this->objeks = ObjekPajak::get();
        $this->subjeks = SubjekPajak::get();
        $this->periodes = Periode::get();
        $this->sppts = Sppt::get();
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $impor = null;
        $sppt = true;
        $objek = $this->objeks->where('letak_objek', $row['letak_objek'])->where('kode_blok', $row['kode_blok'])->first();
        $subjek = $this->subjeks->where('nama_subjek', $row['nama_subjek'])->where('alamat_subjek', $row['alamat_subjek'])->first();
        $periode = $this->periodes->where('tahun', $row['periode'])->first();

        if ($row['status'] == 'Lunas') {
            $this->status = 2;
        } else {
            $this->status = 1;
        }

        if (is_null($periode)) {
            return Session::flash('import-periode-failed', 'Gagal');
        }

        if (!is_null($periode)) {
            $sppt = $this->sppts->where('nop', $row['no_sppt'])
                ->where('objek_pajak_id', $objek->id)
                ->where('subjek_pajak_id', $subjek->id)
                ->where('nilai_pagu_pajak', $row['nilai_pagu_pajak'])
                ->where('status', $this->status)
                ->where('periode_id', $periode->id)
                ->first();
        }

        if (!is_null($periode) && is_null($sppt)) {
            $impor = $this->importTableSppt($row, $objek, $subjek, $periode);
        }

        return $impor;
    }

    public function importTableSppt($row, $objek, $subjek, $periode)
    {
        return new Sppt([
            'nop' => $row['no_sppt'],
            'objek_pajak_id' => $objek->id ?? null,
            'subjek_pajak_id' => $subjek->id ?? null,
            'nilai_pagu_pajak' => $row['nilai_pagu_pajak'],
            'status' => $this->status,
            'periode_id' => $periode->id ?? null,
        ]);
    }
}
