<?php

namespace App\Imports;

use App\Models\Periode;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SheetImportPeriode implements ToModel, WithHeadingRow
{
    private $periodes;

    public function __construct()
    {
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
        $periode = $this->periodes->where('tahun', $row['periode'])->first();

        if (is_null($periode)) {
            $impor = $this->importTablePeriode($row);
        }

        return $impor;
    }

    public function importTablePeriode($row)
    {
        return new Periode([
            'tahun' => $row['periode'],
        ]);
    }
}
