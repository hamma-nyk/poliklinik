<?php

namespace Modules\Inventory\App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths; // Tambahan
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockOpnameExport implements FromView, ShouldAutoSize, WithStyles, WithColumnWidths
{
    protected $opname;

    public function __construct($opname)
    {
        $this->opname = $opname;
    }

    public function view(): View
    {
        return view('inventory::stock_opnames.print', [
            'opname' => $this->opname,
            'is_excel' => true
        ]);
    }

    // 1. Setting Lebar Kolom Manual (Biar Excel tidak sempit)
    public function columnWidths(): array
    {
        return [
            'A' => 10,  // No
            'B' => 15, // Kode Obat
            'C' => 40, // Nama Obat (Dibuat Lebar)
            'D' => 10, // Satuan
            'E' => 12, // Stok Sistem
            'F' => 12, // Stok Fisik
            'G' => 12, // Selisih
            'H' => 30, // Keterangan (Dibuat Lebar)
        ];
    }

    // 2. Styling Tambahan (Header Bold & Border)
    public function styles(Worksheet $sheet)
    {
        return [
            // Baris ke-8 adalah Header Tabel (Sesuaikan jika posisi baris berubah)
            7 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '2C3E50']], // Warna Header Gelap
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            ],
            // Styling seluruh tabel agar text ada di tengah secara vertikal
            'A7:H7' => [
                'alignment' => ['vertical' => 'center'],
            ]
        ];
    }
}