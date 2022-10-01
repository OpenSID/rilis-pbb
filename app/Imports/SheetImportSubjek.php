<?php

namespace App\Imports;

use App\Models\SubjekPajak;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SheetImportSubjek implements ToModel, WithHeadingRow
{
    private $subjeks;

    public function __construct()
    {
        $this->subjeks = SubjekPajak::get();
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $impor = null;
        $subjek = $this->subjeks->where('nama_subjek', $row['nama_subjek'])->first();

        if (is_null($subjek)) {
            $impor = $this->importTableSubjek($row);
        }

        return $impor;
    }

    public function importTableSubjek($row)
    {
        $kategori = 1;
        if ($row['kategori'] == 'Penduduk') {
            $kategori = 1;
        } else if ($row['kategori'] == 'Luar Penduduk') {
            $kategori = 2;
        } else if ($row['kategori'] == 'Badan') {
            $kategori = 3;
        }

        return new SubjekPajak([
            'nama_subjek' => $row['nama_subjek'],
            'alamat_subjek' => $row['alamat_subjek'],
            'kategori' => $kategori,
            'npwp' => $row['npwp'],
            'penduduk' => null,
        ]);
    }
}
