<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kunjungan Pasien</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; text-transform: uppercase; font-size: 16px; }
        .header p { margin: 2px 0; font-size: 10px; }
        .period { font-size: 12px; margin-top: 5px; font-weight: bold; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; text-align: center; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        /* Badge Karyawan/Umum versi Text */
        .badge { font-weight: bold; font-size: 9px; text-transform: uppercase; }
        .badge-karyawan { color: #0044cc; } /* Biru */
        .badge-umum { color: #006600; } /* Hijau */

        .footer { margin-top: 30px; text-align: right; font-size: 10px; font-style: italic; color: #555; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Poliklinik Perusahaan Sehat Jaya</h2>
        <p>Jl. Industri No. 123, Kawasan Industri, Jakarta</p>
        <p>Laporan Kunjungan Pasien (Rawat Jalan)</p>
        
        <div class="period">
            Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 12%;">Waktu</th>
                <th style="width: 10%;">No. RM</th>
                <th style="width: 20%;">Nama Pasien</th>
                <th style="width: 10%;">Kategori</th>
                <th style="width: 20%;">Diagnosa (ICD-10)</th>
                <th style="width: 15%;">Dokter</th>
                <!-- <th style="width: 9%;">Lab Check</th> -->
            </tr>
        </thead>
        <tbody>
    @forelse($data as $index => $row)
    <tr>
        <td class="text-center">{{ $loop->iteration }}</td>
        
        <td class="text-center">
            {{ $row->created_at->format('d/m/Y') }}<br>
            <span style="font-size: 9px; color: #666;">{{ $row->created_at->format('H:i') }}</span>
        </td>

        <td class="text-center">{{ $row->code }}</td>

        <td>
            <strong>{{ $row->patient->name }}</strong>
            <br><span style="font-size: 9px;">{{ $row->patient->gender }}/{{ \Carbon\Carbon::parse($row->patient->birth_date)->age }}Th</span>
        </td>

        <td class="text-center">
            <span class="badge {{ $row->patient->type == 'karyawan' ? 'badge-karyawan' : 'badge-umum' }}">
                {{ $row->patient->type }}
            </span>
            <br>
            <span style="font-size: 9px; font-weight:bold; color: #333;">
                ({{ $row->jenis_kunjungan }})
            </span>
        </td>

        <td>
            @if($row->jenis_kunjungan == 'Poli Umum')
                {{ $row->diagnosis->name ?? $row->diagnosa }}
            @else
                <span style="font-size: 9px;">
                    @if($row->gula_darah) GDS:{{$row->gula_darah}} @endif
                    @if($row->kolesterol) Chol:{{$row->kolesterol}} @endif
                    @if($row->asam_urat) UA:{{$row->asam_urat}} @endif
                </span>
            @endif
        </td>

        <td>
            @if($row->jenis_kunjungan == 'Poli Umum')
                {{ $row->doctor->name }}
            @else
                {{ $row->petugas_name }}
            @endif
        </td>

        <!-- <td class="text-center">
            @if($row->gula_darah || $row->kolesterol || $row->asam_urat)
                Yes
            @else
                -
            @endif
        </td> -->
    </tr>
    @empty
    <tr>
        <td colspan="8" class="text-center" style="padding: 20px;">Tidak ada data kunjungan.</td>
    </tr>
    @endforelse
</tbody>
    </table>

    <div class="footer">
        Dicetak oleh: {{ auth()->user()->name }} | Tanggal: {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>