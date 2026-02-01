<!DOCTYPE html>
<html>
<head>
    <title>Rekam Medis - {{ $record->code }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 10px; }
        
        .meta-table { width: 100%; margin-bottom: 20px; }
        .meta-table td { padding: 4px; vertical-align: top; }
        .label { font-weight: bold; width: 120px; }

        .section-title { font-weight: bold; font-size: 13px; margin-bottom: 5px; border-bottom: 1px solid #ddd; padding-bottom: 3px; margin-top: 15px; }
        
        .grid-vital { width: 100%; margin-bottom: 10px; }
        .grid-vital td { width: 25%; text-align: center; background: #f0f0f0; padding: 5px; border: 1px solid #fff; }
        .vital-val { font-weight: bold; font-size: 14px; display: block; }
        
        .medicine-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .medicine-table th, .medicine-table td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        .medicine-table th { background-color: #eee; }

        .footer { margin-top: 40px; text-align: right; }
        .ttd-box { display: inline-block; text-align: center; width: 200px; }
        .ttd-space { height: 60px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Poliklinik Perusahaan Sehat Jaya</h1>
        <p>Jl. Industri No. 123, Kawasan Industri, Jakarta</p>
        <p>Telp: (021) 1234-5678 | Email: medika@perusahaan.com</p>
    </div>

    <div style="text-align: center; font-weight: bold; font-size: 14px; margin-bottom: 15px;">
        LEMBAR HASIL PEMERIKSAAN MEDIS
    </div>

    <table class="meta-table">
        <tr>
            <td class="label">No. Rekam Medis</td>
            <td>: {{ $record->code }}</td>
            <td class="label">Tanggal</td>
            <td>: {{ $record->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td class="label">Nama Pasien</td>
            <td>: {{ $record->patient->name }}</td>
            <td class="label">Dokter</td>
            <td>: {{ $record->doctor->name }}</td>
        </tr>
        <tr>
            <td class="label">KTP</td>
            <td>: {{ $record->patient->ktp }}</td>
            <td class="label">Kategori</td>
            <td>: {{ ucfirst($record->patient->type) }}</td>
        </tr>
        @if ($record->patient->type == 'karyawan')
        <tr>
            <td class="label">NIK</td>
            <td>: {{ $record->patient->nik }}</td>
            <td class="label">Bagian</td>
            <td>: {{ $record->patient->subbag_dept }}</td>
        </tr>
        @endif        
        </tr>
            <td class="label">Usia / Gender</td>
            <td>: {{ \Carbon\Carbon::parse($record->patient->birth_date)->age }} Thn / {{ $record->patient->gender }}</td>
            <td class="label">No HP</td>
            <td>: {{ $record->patient->phone }}</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td colspan="3" rowspan="2">: {{ $record->patient->alamat }}</td>
        </tr>
    </table>

    <div class="section-title">A. TANDA VITAL</div>
    <table class="grid-vital">
        <tr>
            <td>Tensi<br><span class="vital-val">{{ $record->tensi ?? '-' }}</span> mmHg</td>
            <td>Suhu<br><span class="vital-val">{{ $record->suhu_tubuh ?? '-' }}</span> °C</td>
            <td>Berat<br><span class="vital-val">{{ $record->berat_badan ?? '-' }}</span> Kg</td>
            <td>Tinggi<br><span class="vital-val">{{ $record->tinggi_badan ?? '-' }}</span> cm</td>
        </tr>
    </table>

    <div class="section-title">B. HASIL PEMERIKSAAN</div>
    <table width="100%">
        <tr>
            <td width="130" style="vertical-align: top; font-weight: bold;">Keluhan Utama</td>
            <td>: {{ $record->keluhan_utama }}</td>
        </tr>
        <tr>
            <td style="vertical-align: top; font-weight: bold;">Riwayat Alergi</td>
            <td>: <span style="color: red;">{{ $record->riwayat_alergi ?? '-' }}</span></td>
        </tr>
        <tr>
            <td style="vertical-align: top; font-weight: bold;">Diagnosa</td>
            <td>: <strong>{{ $record->diagnosis->name ?? $record->diagnosa }}</strong> ({{ $record->diagnosis->code ?? '' }})</td>
        </tr>
        <tr>
            <td style="vertical-align: top; font-weight: bold;">Tindakan</td>
            <td>: {{ $record->tindakan ?? '-' }}</td>
        </tr>
    </table>

    <div class="section-title">C. RESEP OBAT</div>
    <table class="medicine-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th style="text-align: center;">Jml</th>
                <th>Aturan Pakai</th>
            </tr>
        </thead>
        <tbody>
            @forelse($record->medicines as $index => $item)
            <tr>
                <td style="width: 20px; text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $item->medicine->name ?? 'Obat Dihapus' }}</td>
                <td style="text-align: center;">{{ $item->quantity }}</td>
                <td>{{ $item->instructions }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; font-style: italic;">Tidak ada resep obat</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="ttd-box">
            <p>Dokter Pemeriksa,</p>
            <div class="ttd-space"></div>
            <p style="text-decoration: underline; font-weight: bold;">{{ $record->doctor->name }}</p>
        </div>
    </div>

</body>
</html>