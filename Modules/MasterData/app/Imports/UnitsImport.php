<?php

namespace Modules\MasterData\App\Imports;

use Modules\MasterData\App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UnitsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return Unit::updateOrCreate(
            ['code' => $row['code']], // Kunci unik
            ['name' => $row['name']]  // Data yang disimpan
        );
    }
}