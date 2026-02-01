<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pemakaian Obat</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .period { font-size: 11px; margin-top: 5px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; font-weight: bold; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .footer { margin-top: 30px; text-align: right; font-size: 10px; font-style: italic; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Rekapitulasi Pemakaian Obat</h2>
        <div class="period">
            Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Kode Obat</th>
                <th>Nama Obat</th>
                <th style="width: 10%;">Satuan</th>
                <th style="width: 15%;">Total Keluar</th>
                <th style="width: 15%;">Sisa Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $row)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $row->medicine->code ?? '-' }}</td>
                <td>{{ $row->medicine->name ?? 'Obat Dihapus' }}</td>
                <td class="text-center">{{ $row->medicine->unit ?? '-' }}</td>
                <td class="text-center" style="font-weight: bold;">{{ $row->total_qty }}</td>
                <td class="text-center" style="color: #555;">{{ $row->medicine->current_stock ?? 0 }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }} WIB | Oleh: {{ auth()->user()->name }}</p>
    </div>

</body>
</html>