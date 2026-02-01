<!DOCTYPE html>
<html>
<head>
    <title>Laporan Mutasi Stok</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 6px; }
        th { background-color: #eee; text-align: center; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Mutasi Stok (Keluar - Masuk)</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Obat</th>
                <th width="10%">Satuan</th>
                <th width="15%">Jml Masuk</th>
                <th width="15%">Jml Keluar</th>
                <th width="15%">Stok Saat Ini</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $row)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>
                    <b>{{ $row->name }}</b><br>
                    <small>{{ $row->code }}</small>
                </td>
                <td class="text-center">{{ $row->unit }}</td>
                <td class="text-center" style="color: green;">{{ $row->total_in ?? 0 }}</td>
                <td class="text-center" style="color: red;">{{ $row->total_out ?? 0 }}</td>
                <td class="text-center" style="font-weight: bold;">{{ $row->current_stock }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 20px; font-size: 10px; font-style: italic;">
        * Stok Saat Ini adalah stok fisik realtime saat laporan dicetak, bukan sisa historis.
    </div>
</body>
</html>