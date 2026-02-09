<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Stock Opname - {{ $opname->code }}</title>
    <style>
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            font-size: 12px; 
            color: #333;
        }
        
        /* HEADER SURAT */
        .header { 
            text-align: center; 
            margin-bottom: 25px; 
            padding-bottom: 10px;
            border-bottom: 3px double #444; /* Garis bawah ganda ala kop surat */
        }
        .header h2 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 14px; font-weight: bold; }

        /* INFO META DATA */
        .meta-table { width: 100%; margin-bottom: 20px; font-size: 13px; }
        .meta-table td { padding: 4px; vertical-align: top; }
        .label { font-weight: bold; width: 15%; }
        .sep { width: 2%; text-align: center; }
        .val { width: 33%; }
        
        /* TABEL DATA UTAMA */
        .data-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
        }
        .data-table th, .data-table td { 
            border: 1px solid #000; 
            padding: 8px 6px; 
            vertical-align: middle; /* Text selalu di tengah vertikal */
        }
        
        /* Styling Header Tabel */
        .data-table th { 
            background-color: #2c3e50; /* Warna Biru Tua Professional */
            color: #ffffff; /* Text Putih */
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
            text-align: center;
        }

        /* Warna Baris Belang (Zebra Striping) - Hanya efek di PDF */
        @if(!isset($is_excel) || !$is_excel)
        .data-table tbody tr:nth-child(even) { background-color: #f9f9f9; }
        @endif
        
        /* Helper Classes */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        
        /* Indikator Warna */
        .bg-red { background-color: #ffebee; color: #c62828; } /* Merah Soft */
        .bg-green { background-color: #e8f5e9; color: #2e7d32; } /* Hijau Soft */
        
        /* TANDA TANGAN */
        .signature-table { width: 100%; margin-top: 40px; page-break-inside: avoid; }
        .signature-table td { text-align: center; width: 33%; }
        .signature-space { height: 80px; }
        .signer-name { font-weight: bold; text-decoration: underline; }

        /* Khusus Excel: Hilangkan border header surat biar rapi */
        @if(isset($is_excel) && $is_excel)
            .header { border-bottom: none; }
        @endif
    </style>
</head>
<body>

    {{-- HEADER KOP --}}
    <div class="header">
        <h2>Laporan Hasil Stock Opname</h2>
        <p>Poliklinik PT. Nusantara Building Industries</p>
    </div>

    {{-- INFO STOCK OPNAME --}}
    <table class="meta-table">
        <tr>
            <td class="label">Kode SO</td>
            <td class="sep">:</td>
            <td class="val">{{ $opname->opname_number }}</td>

            <td class="label">Tanggal</td>
            <td class="sep">:</td>
            <td class="val">{{ date('d F Y', strtotime($opname->created_at)) }}</td>
        </tr>
        <tr>
            <td class="label">Pelaksana</td>
            <td class="sep">:</td>
            <td class="val">{{ $opname->creator->name ?? 'System' }}</td>

            <td class="label">Status</td>
            <td class="sep">:</td>
            <td class="val" style="text-transform: uppercase;">{{ $opname->status }}</td>
        </tr>
        <tr>
            <td class="label">Catatan</td>
            <td class="sep">:</td>
            <td class="val" colspan="4">{{ $opname->note ?? '-' }}</td>
        </tr>
    </table>

    {{-- TABEL DATA BARANG --}}
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Kode Obat</th>
                <th>Nama Obat</th>
                <th>Satuan</th>
                <th>Stok Sistem</th>
                <th>Stok Fisik</th>
                <th>Selisih</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($opname->items as $index => $item)
                @php
                    $system = $item->system_stock ?? 0;
                    $real   = $item->real_stock ?? 0;
                    $diff   = $real - $system;

                    // Logika Warna Excel & PDF
                    // Menggunakan Hex Code agar Excel membacanya dengan baik
                    $textColor = '#000000';
                    if ($diff < 0) {
                        $textColor = '#FF0000'; // Merah
                    } elseif ($diff > 0) {
                        $textColor = '#008000'; // Hijau
                    }
                    
                    $obatName = $item->medicine->name ?? '-';
                    $obatCode = $item->medicine->code ?? '-';
                    $obatUnit = $item->medicine->unit ?? '-';
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $obatCode }}</td>
                    <td>{{ $obatName }}</td>
                    <td class="text-center">{{ $obatUnit }}</td>
                    <td class="text-center">{{ $system }}</td>
                    <td class="text-center">{{ $real }}</td>
                    <td class="text-center font-bold" style="color: {{ $textColor }};">
                        {{ $diff > 0 ? '+'.$diff : $diff }}
                    </td>
                    <td>{{ $item->note ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TANDA TANGAN (Hanya muncul di PDF) --}}
    @if(!isset($is_excel) || !$is_excel)
    <table class="signature-table">
        <tr>
            <td>
                Dibuat Oleh,<br>
                <div class="signature-space"></div>
                <div class="signer-name">{{ $opname->creator->name ?? 'Admin Logistik' }}</div>
                <div>Pelaksana</div>
            </td>
            <td>
                Diperiksa Oleh,<br>
                <div class="signature-space"></div>
                <div class="signer-name">____________________</div>
                <div>Apoteker / SPV</div>
            </td>
            <td>
                Disetujui Oleh,<br>
                <div class="signature-space"></div>
                <div class="signer-name">____________________</div>
                <div>Kepala Klinik</div>
            </td>
        </tr>
    </table>
    @endif

</body>
</html>