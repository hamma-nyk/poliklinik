<!DOCTYPE html>
<html>
<head>
    <title>Laporan 10 Besar Penyakit</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .period { font-size: 11px; color: #555; margin-top: 5px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px 10px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; font-weight: bold; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        
        .footer { margin-top: 30px; text-align: right; font-size: 11px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Daftar Penyakit</h2>
        <div class="period">
            Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">Rank</th>
                <th style="width: 15%;">Kode ICD</th>
                <th>Nama Penyakit</th>
                <th style="width: 15%;">Jumlah Kasus</th>
                <th style="width: 15%;">Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $row)
                @php
                    $percent = $grandTotal > 0 ? ($row->total / $grandTotal) * 100 : 0;
                @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $row->diagnosis->code ?? '-' }}</td>
                <td>{{ $row->diagnosis->name ?? '-' }}</td>
                <td class="text-center font-bold">{{ $row->total }}</td>
                <td class="text-center">{{ number_format($percent, 1) }} %</td>
            </tr>
            @endforeach
            
            <tr style="background-color: #fafafa; font-weight: bold;">
                <td colspan="3" class="text-right">TOTAL SAMPEL DIAGNOSA</td>
                <td class="text-center">{{ $grandTotal }}</td>
                <td class="text-center">100%</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }} WIB</p>
    </div>

</body>
</html>