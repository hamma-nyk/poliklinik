<!DOCTYPE html>
<html>
<head>
    <title>Laporan Adjustment Periode</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid #333; padding: 5px; }
        .table th { background-color: #eee; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-red { color: red; font-weight: bold; }
        .text-green { color: green; font-weight: bold; }
        
        @if(isset($is_excel) && $is_excel)
            .header, .table th { border: none; }
        @endif
    </style>
</head>
<body>

    <div class="header">
        <h2 style="margin:0;">REKAPITULASI ADJUSTMENT STOK</h2>
        <p style="margin:5px;">Periode: {{ date('d/m/Y', strtotime($start_date)) }} s/d {{ date('d/m/Y', strtotime($end_date)) }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Tanggal</th>
                <th>Kode Obat</th>
                <th>Nama Obat</th>
                <th>Satuan</th>
                <th>Qty</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $index => $item)
                @php
                    // 1. Ambil Type dari relasi TRANSACTION (Parent)
                    $type = $item->transaction->type; // 'in' atau 'out'
                    
                    // 2. Ambil Qty (Anggaplah di database nilainya selalu positif)
                    $qty = $item->quantity; 

                    // 3. Tentukan Warna & Tanda Baca
                    if ($type == 'out') {
                        $color = 'text-red';      // Merah
                        $displayQty = '-' . $qty; // Kasih tanda minus
                        $keteranganType = 'Pengurangan (Out)';
                    } else {
                        $color = 'text-green';    // Hijau
                        $displayQty = '+' . $qty; // Kasih tanda plus
                        $keteranganType = 'Penambahan (In)';
                    }
                @endphp

                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ date('d/m/Y', strtotime($item->transaction->transaction_date)) }}</td>
                    <td class="text-center">{{ $item->medicine->code ?? '-' }}</td>
                    <td>{{ $item->medicine->name ?? '-' }}</td>
                    <td class="text-center">{{ $item->medicine->unit ?? '-' }}</td>
                    
                    {{-- Tampilkan Qty dengan Warna --}}
                    <td class="text-center font-bold {{ $color }}">
                        {{ $displayQty }}
                    </td>

                    {{-- Tampilkan Type dan Catatan --}}
                    <td>
                        <span style="font-size: 10px; color: #666;">[{{ $keteranganType }}]</span><br>
                        {{ $item->transaction->notes ?? '-' }}
                    </td>
                </tr>
            @empty
            <tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>
        @endforelse
    </tbody>    
    </table>

</body>
</html>