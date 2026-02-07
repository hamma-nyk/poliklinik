<?php

namespace Modules\Clinical\App\Exports;

use Modules\Clinical\App\Models\SickLeave;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SickLeaveExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return SickLeave::with(['patient', 'medicalRecord.doctor', 'medicalRecord.nurse']) // Load relasi
            ->whereBetween('start_date', [$this->startDate, $this->endDate])
            ->latest('start_date')
            ->get();
    }

    public function headings(): array
    {
        return [
            'NIK',
            'No. KTP',
            'Nama Karyawan',
            'Bagian (Dept)',
            'Jabatan',
            'Nomor SKD',
            'Tgl Mulai',
            'Tgl Akhir',
            'Lama (Hari)',
            'Nama Dokter',
            'Nama Perawat',
            'Nama RSUD/Poli',
            'Diagnosa / Keterangan',
            'Status',
        ];
    }

    public function map($row): array
    {
        // 1. Logika Nama Dokter & Perawat (Internal)
        $dokter = '-';
        $perawat = '-';
        $klinik = '-';
        $diagnosa = $row->notes; // Default diagnosa dari notes

        if ($row->type == 'internal') {
            $klinik = 'Klinik Internal Perusahaan';
            
            // Cek apakah pemeriksa Dokter atau Perawat (Berdasarkan model class)
            $examiner = $row->medicalRecord->examiner ?? null;
            if ($examiner) {
                // Asumsi namespace model Dokter mengandung kata 'Doctor'
                if (str_contains(get_class($examiner), 'Doctor')) {
                    $dokter = $examiner->name;
                } else {
                    $perawat = $examiner->nama ?? $examiner->name; // Sesuaikan field nama di tabel perawat
                }
            }
            
            // Jika Anda punya relasi diagnosa ICD10 di medical record, ambil dari sana
            // $diagnosa = $row->medicalRecord->icd10->name ?? $row->notes;

        } else {
            // Jika Eksternal
            $klinik = $row->external_clinic_name;
            $dokter = $row->external_doctor_name;
        }

        return [
            $row->patient->nik ?? '-',
            $row->patient->ktp ?? '-', // Pastikan ada kolom ktp di tabel pasien
            $row->patient->name,
            $row->patient->department->name ?? '-',
            $row->patient->position->name ?? '-',
            $row->reg_number,
            $row->start_date,
            $row->end_date,
            $row->duration_days,
            $dokter,
            $perawat,
            $klinik,
            $diagnosa,
            ucfirst($row->type),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Header Bold
        ];
    }
}