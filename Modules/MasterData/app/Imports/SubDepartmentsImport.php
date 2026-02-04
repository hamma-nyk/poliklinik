<?php

namespace Modules\MasterData\App\Imports;

use Modules\MasterData\App\Models\SubDepartment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubDepartmentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return SubDepartment::updateOrCreate(
            ['code' => $row['code']], // Cek kode agar tidak duplikat
            ['name' => $row['name']]
        );
    }
}