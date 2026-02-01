<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok Menipis</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 6px; }
        th { background-color: #eee; text-align: center; }
        .text-center { text-align: center; }
        .danger { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Stok Obat Menipis / Habis</h2>
        <p>Dicetak per tanggal: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode</th>
                <th>Nama Obat</th>
                <th width="10%">Satuan</th>
                <th width="15%">Sisa Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $row)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $row->code }}</td>
                <td>{{ $row->name }}</td>
                <td class="text-center">{{ $row->unit }}</td>
                <td class="text-center danger">{{ $row->current_stock }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>