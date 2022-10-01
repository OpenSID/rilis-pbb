<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportSppt implements ToModel, WithHeadingRow, WithMultipleSheets
{
    use WithConditionalSheets;

    public function __construct()
    {
    }

    public function conditionalSheets(): array
    {
        return [
            'SPPT' => new SheetImportSppt(),
        ];
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        return 0;
    }
}
