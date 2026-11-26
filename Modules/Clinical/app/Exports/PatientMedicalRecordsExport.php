<?php

namespace Modules\Clinical\App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PatientMedicalRecordsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $records;
    protected $no = 0;

    public function __construct($records)
    {
        $this->records = $records;
    }

    public function collection()
    {
        return collect($this->records);
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Pemeriksaan',
            'No. RM',
            'Nama Pasien',
            'Kode Pasien',
            'Keluhan Utama',
            'Kode ICD-10',
            'Diagnosa',
            'Tindakan',
            'Tensi',
            'Suhu (°C)',
            'Dokter',
            'Perawat',
        ];
    }

    public function map($record): array
    {
        $this->no++;

        return [
            $this->no,
            $record->created_at ? $record->created_at->format('d/m/Y H:i') : '-',
            $record->code ?? '-',
            $record->patient->name ?? '-',
            $record->patient->code ?? '-',
            $record->keluhan_utama ?? '-',
            $record->diagnosis->code ?? '-',
            $record->diagnosis->name ?? ($record->diagnosa ?? '-'),
            $record->tindakan ?? '-',
            $record->tensi ?? '-',
            $record->suhu_tubuh ?? '-',
            $record->doctor->name ?? '-',
            $record->nurse->name ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
