<?php

namespace App\Imports;

use App\Models\Rayon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SheetImportRayon implements ToModel, WithHeadingRow
{
    private $rayons;

    public function __construct()
    {
        $this->rayons = Rayon::select('id', 'nama_rayon')->get();
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $impor = null;
        $rayon = $this->rayons->where('nama_rayon', $row['nama_rayon'])->first();

        if (is_null($rayon)) {
            $impor = $this->importTableRayon($row);
        }

        return $impor;
    }

    public function importTableRayon($row)
    {
        return new Rayon([
            'nama_rayon' => $row['nama_rayon'],
        ]);
    }
}
