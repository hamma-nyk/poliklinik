<!DOCTYPE html>
<html>
<head>
    <title>Laporan Detail Pemakaian Obat</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 10px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; font-size: 16px; }
        .period { font-size: 11px; margin-top: 5px; color: #555; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; table-layout: fixed; }
        th, td { border: 1px solid #444; padding: 5px; word-wrap: break-word; }
        th { background-color: #f2f2f2; text-align: center; font-weight: bold; text-transform: uppercase; font-size: 9px; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        
        /* Baris judul obat */
        .row-medicine-header { background-color: #e2e8f0; font-weight: bold; }
        /* Baris subtotal per obat */
        .row-subtotal { background-color: #f8fafc; font-style: italic; }
        
        .footer { margin-top: 30px; text-align: right; font-size: 9px; font-style: italic; border-top: 1px solid #ccc; padding-top: 5px; }
        
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

    @php $grandTotalQty = 0; @endphp

    @forelse($data as $medicineId => $group)
        @php
            $medicine = $group->first()->medicine;
            $subtotalQty = $group->sum('quantity');
            $grandTotalQty += $subtotalQty;
        @endphp

        <table>
            <thead>
                {{-- Header informasi nama obat per kelompok --}}
                <tr class="row-medicine-header">
                    <td colspan="5" style="border-bottom: none; font-size: 11px;">
                        {{ $medicine->name ?? 'Obat Dihapus' }} ({{ $medicine->code ?? '-' }})
                    </td>
                </tr>
                <tr>
                    <th style="width: 25px;">No</th>
                    <th style="width: 75px;">Tgl Keluar</th>
                    <th>Referensi / Pasien / Keterangan</th>
                    <th>STATUS</th>
                    <th style="width: 35px;">Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach($group as $index => $row)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">{{ $row->transaction->transaction_date->format('d/m/Y') }}</td>
                        <td>
                            @if($row->transaction->medicalRecord)
                                <span class="badge-resep">RESEP:</span> {{ $row->transaction->medicalRecord->patient->name }}
                                <span style="font-size: 8px; color: #666;">({{ $row->transaction->medicalRecord->code }})</span>
                            @else
                                <span class="badge-adj">ADJ/LAIN:</span> {{ $row->transaction->notes ?? '-' }}
                            @endif
                        </td>
                        <td class="text-center font-bold uppercase">
                            @if($row->transaction->medicalRecord)
                                <span class="px-2 py-0.5 rounded-md text-[9px] font-bold uppercase {{ $row->transaction->medicalRecord->patient->type == 'karyawan' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ strtoupper($row->transaction->medicalRecord?->patient->type) ?? 'UMUM' }}
                                </span>
                            @else
                                ADJ/LAIN
                            @endif
                        </td>
                        <td class="text-center">{{ number_format($row->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="row-subtotal">
                    <td colspan="4" class="text-right font-bold" style="padding-right: 10px;">TOTAL {{ $medicine->name ?? '' }}</td>
                    <td class="text-center font-bold">{{ number_format($subtotalQty, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
        {{-- Memberi jarak antar tabel obat --}}
        <div style="height: 15px;"></div>

    @empty
        <table style="width: 100%;">
            <tr>
                <td class="text-center" style="padding: 20px;">Data transaksi tidak ditemukan untuk periode ini.</td>
            </tr>
        </table>
    @endforelse

    {{-- Grand Total Keseluruhan --}}
    @if($grandTotalQty > 0)
    <table style="margin-top: 10px; background-color: #333; color: white;">
        <tr>
            <td class="text-right font-bold" style="font-size: 11px; padding-right: 10px; border: none;">TOTAL KESELURUHAN ITEM KELUAR</td>
            <td class="text-center font-bold" style="font-size: 11px; width: 35px; border: none;">{{ number_format($grandTotalQty, 0, ',', '.') }}</td>
        </tr>
    </table>
    @endif

    <div class="footer">
        <p>Dokumen ini dicetak otomatis melalui Sistem Klinik pada: {{ now()->format('d/m/Y H:i:s') }} WIB</p>
        <p>Dicetak oleh: {{ auth()->user()->name }}</p>
    </div>

</body>
</html>