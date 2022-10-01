<?php

namespace App\Imports;

use App\Models\ObjekPajak;
use App\Models\RT;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SheetImportObjek implements ToModel, WithHeadingRow
{
    private $rts;
    private $objeks;

    public function __construct()
    {
        $this->rts = RT::get();
        $this->objeks = ObjekPajak::get();
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $impor = null;
        $rt = $this->rts->where('nama_rt', $row['nama_rt'])->first();
        $objek = $this->objeks->where('letak_objek', $row['letak_objek'])
            ->where('kode_blok', $row['kode_blok'])
            ->where('alamat_objek', $row['alamat_objek'])
            ->where('rt_id', $rt->id)
            ->first();

        if (is_null($objek)) {
            $impor = $this->importTableObjek($row, $rt);
        }

        return $impor;
    }

    public function importTableObjek($row, $rt)
    {
        return new ObjekPajak([
            'letak_objek' => $row['letak_objek'],
            'kode_blok' => $row['kode_blok'],
            'rt_id' => $rt->id,
            'alamat_objek' => $row['alamat_objek'],
        ]);
    }
}
