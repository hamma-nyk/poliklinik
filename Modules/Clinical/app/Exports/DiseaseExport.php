<?php

namespace Modules\Clinical\App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DiseaseExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $data;
    protected $grandTotal;
    protected $rank = 0;

    /**
     * Menerima data dari Controller
     */
    public function __construct($data, $grandTotal)
    {
        $this->data = $data;
        $this->grandTotal = $grandTotal;
    }

    /**
     * Mengembalikan data koleksi untuk diproses Excel
     */
    public function collection()
    {
        // Gunakan collect() untuk berjaga-jaga jika $this->data berupa array biasa
        return collect($this->data);
    }

    /**
     * Membuat Header Kolom Excel
     */
    public function headings(): array
    {
        return [
            'Rank',
            'Kode Diagnosa (ICD-10)',
            'Nama Diagnosa / Penyakit',
            'Jumlah Kasus (Pasien)',
            'Persentase Distribusi (%)'
        ];
    }

    /**
     * Memetakan data ke setiap baris Excel
     */
    public function map($row): array
    {
        $this->rank++;
        
        // Kalkulasi persentase dengan aman
        $percent = $this->grandTotal > 0 ? ($row->total / $this->grandTotal) * 100 : 0;

        return [
            $this->rank,
            $row->diagnosis->code ?? '-',
            $row->diagnosis->name ?? 'Diagnosa Dihapus',
            $row->total,
            round($percent, 2) // Dibulatkan 2 angka di belakang koma
        ];
    }

    /**
     * Memberikan styling dasar (Bold pada Header)
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Baris 1 (Header) dicetak tebal
            1 => ['font' => ['bold' => true]],
        ];
    }
}