<!DOCTYPE html>
<html>
<head>
    <title>Laporan Detail Obat Masuk</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 10px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; font-size: 16px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; table-layout: fixed; }
        th, td { border: 1px solid #444; padding: 5px; word-wrap: break-word; }
        th { background-color: #f2f2f2; text-align: center; font-weight: bold; text-transform: uppercase; font-size: 8px; }
        
        /* Baris judul grup obat */
        .row-medicine-header { background-color: #e2e8f0; font-weight: bold; font-size: 10px; }
        /* Baris subtotal per obat */
        .row-subtotal { background-color: #f8fafc; font-style: italic; font-weight: bold; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .footer { margin-top: 30px; text-align: right; font-size: 9px; font-style: italic; border-top: 1px solid #ccc; padding-top: 5px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Detail Pengadaan Obat (Incoming)</h2>
        <div style="font-size: 11px; margin-top: 5px;">
            Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
        </div>
    </div>

    @php $grandTotalInvestasi = 0; @endphp

    @forelse($data as $medicineId => $group)
        @php
            $medicine = $group->first()->medicine;
            $subtotalQty = $group->sum('quantity');
            $subtotalAmount = $group->sum(function($i) { return $i->quantity * $i->price_at_moment; });
            $grandTotalInvestasi += $subtotalAmount;
        @endphp

        <table>
            <thead>
                <tr class="row-medicine-header">
                    <td colspan="5">
                        {{ strtoupper($medicine->name ?? 'Obat Dihapus') }} ({{ $medicine->code ?? '-' }})
                    </td>
                </tr>
                <tr>
                    <th style="width: 25px;">No</th>
                    <th style="width: 70px;">Tgl Masuk</th>
                    <th>Supplier / No. Faktur</th>
                    <th style="width: 40px;">Qty</th>
                    <th style="width: 100px;">Harga Beli (@)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($group as $index => $row)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $row->transaction->transaction_date->format('d/m/Y') }}</td>
                    <td>
                        <span style="font-weight: bold;">{{ $row->transaction->supplier->name ?? 'Tanpa Supplier' }}</span>
                        <div style="font-size: 8px; color: #666;">Faktur: {{ $row->transaction->invoice_number ?? '-' }}</div>
                    </td>
                    <td class="text-center">{{ number_format($row->quantity, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($row->price_at_moment, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="row-subtotal">
                    <td colspan="3" class="text-right">SUBTOTAL NILAI {{ strtoupper($medicine->name) }}</td>
                    <td class="text-center">{{ number_format($subtotalQty, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($subtotalAmount, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
        <div style="height: 10px;"></div> {{-- Spasi antar grup obat --}}

    @empty
        <table style="width: 100%;">
            <tr>
                <td class="text-center" style="padding: 20px;">Data transaksi tidak ditemukan.</td>
            </tr>
        </table>
    @endforelse

    {{-- TOTAL AKHIR SELURUH PENGADAAN --}}
    @if($grandTotalInvestasi > 0)
    <table style="margin-top: 10px; background-color: #333; color: white;">
        <tr>
            <td colspan="4" class="text-right" style="padding: 8px; font-weight: bold; border: none;">
                TOTAL INVESTASI PENGADAAN (GRAND TOTAL)
            </td>
            <td class="text-right" style="padding: 8px; font-weight: bold; border: none; width: 100px;">
                Rp {{ number_format($grandTotalInvestasi, 0, ',', '.') }}
            </td>
        </tr>
    </table>
    @endif

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }} | Oleh: {{ auth()->user()->name }}</p>
    </div>

</body>
</html>