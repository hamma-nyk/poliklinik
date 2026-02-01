<!DOCTYPE html>
<html>
<head>
    <title>Laporan Obat Masuk</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; }
        th { background-color: #eee; text-align: center; }
        .text-center { text-align: center; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; font-style: italic; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Obat Masuk (Restock)</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</p>
    </div>

   <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode</th>
                <th>Nama Obat</th>
                <th width="10%">Satuan</th>
                <th width="15%">Jumlah Masuk</th>
                <th width="20%">Total Nilai (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($data as $index => $row)
            @php $grandTotal += $row->total_amount; @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $row->medicine->code ?? '-' }}</td>
                <td>{{ $row->medicine->name ?? '-' }}</td>
                <td class="text-center">{{ $row->medicine->unit ?? '-' }}</td>
                <td class="text-center" style="font-weight: bold;">{{ $row->total_qty }}</td>
                <td class="text-right">Rp {{ number_format($row->total_amount, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            
            <tr style="background-color: #eee; font-weight: bold;">
                <td colspan="5" class="text-right">TOTAL PEMBELIAN</td>
                <td class="text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    <div class="footer">
        <p>Dicetak oleh: {{ auth()->user()->name }} | {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>