<?php

namespace App\Imports;

use App\Models\Rayon;
use App\Models\RT;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SheetImportRt implements ToModel, WithHeadingRow
{
    private $rts;
    private $rayons;

    public function __construct()
    {
        $this->rayons = Rayon::get();
        $this->rts = RT::get();
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
        $rt = $this->rts->where('nama_rt', $row['nama_rt'])->where('rayon_id', $rayon->id)->first();

        if (is_null($rt)) {
            $impor = $this->importTableRt($row, $rayon);
        }

        return $impor;
    }

    public function importTableRt($row, $rayon)
    {
        return new RT([
            'nama_rt' => $row['nama_rt'],
            'rayon_id' => $rayon->id ?? null,
        ]);
    }
}
