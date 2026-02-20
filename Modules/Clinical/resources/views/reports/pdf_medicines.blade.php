<!DOCTYPE html>
<html>
<head>
    <title>Laporan Detail Pemakaian Obat</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 10px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; font-size: 16px; }
        .period { font-size: 11px; margin-top: 5px; color: #555; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 15px; table-layout: fixed; }
        th, td { border: 1px solid #444; padding: 5px; word-wrap: break-word; }
        th { background-color: #f2f2f2; text-align: center; font-weight: bold; text-transform: uppercase; font-size: 9px; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        
        .bg-gray { background-color: #f9f9f9; }
        .footer { margin-top: 30px; text-align: right; font-size: 9px; font-style: italic; border-top: 1px solid #ccc; padding-top: 5px; }
        
        /* Warna untuk membedakan kategori di PDF */
        .badge-resep { color: #1e40af; font-weight: bold; }
        .badge-adj { color: #92400e; font-style: italic; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Detail Pemakaian Obat (Logistik Keluar)</h2>
        <div class="period">
            Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th style="width: 75px;">Tgl Keluar</th>
                <th style="width: 300px;">Nama Obat</th>
                <th>Referensi / Pasien / Keterangan</th>
                <th style="width: 25px;">Qty</th>
                <!-- <th style="width: 60px;">Satuan</th> -->
                <!-- <th style="width: 90px;">Harga Satuan</th>
                <th style="width: 100px;">Subtotal</th> -->
            </tr>
        </thead>
        <tbody>
            @php 
                $grandTotal = 0; 
                $totalqty = 0;
            @endphp
            @forelse($data as $index => $row)
                @php 
                    $subtotal = $row->quantity * $row->price_at_moment;
                    $grandTotal += $subtotal;
                    $totalqty += $row->quantity;
                @endphp
                <tr class="{{ $index % 2 == 0 ? '' : 'bg-gray' }}">
                    <td style="width: 25px;" class="text-center">{{ $index + 1 }}</td>
                    <td style="width: 75px;" class="text-center">{{ $row->transaction->transaction_date->format('d/m/Y') }}</td>
                    <td>
                        <div class="font-bold">{{ $row->medicine->name ?? 'Obat Dihapus' }}</div>
                        <div style="font-size: 8px; color: #666;">{{ $row->medicine->code ?? '-' }}</div>
                    </td>
                    <td>
                        @if($row->transaction->medicalRecord)
                            <span class="badge-resep">RESEP:</span> {{ $row->transaction->medicalRecord->patient->name }}
                            <br>
                            <span style="font-size: 8px; color: #666;">({{ $row->transaction->medicalRecord->code }})</span>
                        @else
                            <span class="badge-adj">ADJ/LAIN:</span> {{ $row->transaction->notes ?? '-' }}
                        @endif
                    </td>
                    <td class="text-center font-bold">{{ number_format($row->quantity, 0, ',', '.') }}</td>
                    <!-- <td class="text-center">{{ $row->medicine->unit ?? '-' }}</td> -->
                    <!-- <td class="text-right">{{ number_format($row->price_at_moment, 2, ',', '.') }}</td>
                    <td class="text-right font-bold">Rp {{ number_format($subtotal, 2, ',', '.') }}</td> -->
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 20px;">Data transaksi tidak ditemukan untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="background-color: #eee;">
                <td colspan="4" class="text-right font-bold" style="font-size: 10px; padding-right: 10px;">TOTAL OBAT KELUAR</td>
                <!-- <td class="text-right font-bold" style="font-size: 11px;">Rp {{ number_format($grandTotal, 2, ',', '.') }}</td> -->
                <td class="text-center font-bold" style="font-size: 11px;">{{ number_format($totalqty, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dokumen ini dicetak otomatis melalui Sistem Klinik pada: {{ now()->format('d/m/Y H:i:s') }} WIB</p>
        <p>Dicetak oleh: {{ auth()->user()->name }}</p>
    </div>

</body>
</html>