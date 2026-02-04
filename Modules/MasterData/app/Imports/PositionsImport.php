<?php

namespace Modules\MasterData\App\Imports;

use Modules\MasterData\App\Models\Position;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PositionsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return Position::updateOrCreate(
            ['code' => $row['code']], // Kunci unik (Kode Jabatan)
            ['name' => $row['name']]  // Nama Jabatan
        );
    }
}