<!DOCTYPE html>
<html>
<head>
    <title>Laporan Rekam Medis Pasien</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 16px; }
        .header h2 { margin: 0; text-transform: uppercase; font-size: 16px; }
        .header p { margin: 2px 0; font-size: 10px; }
        .patient-box { border: 1px solid #444; padding: 8px 10px; margin-bottom: 12px; background: #f9f9f9; }
        .patient-box p { margin: 2px 0; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #f0f0f0; text-align: center; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        .text-center { text-align: center; }
        .footer { margin-top: 24px; text-align: right; font-size: 10px; font-style: italic; color: #555; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Poliklinik PT. Nusantara Building Industries</h2>
        <p>Jl. Raya Semarang - Demak KM. 17, Wonokerto, Karangtengah, Demak, Jawa Tengah, Indonesia</p>
        <p>Laporan Riwayat Rekam Medis Pasien</p>
    </div>

    <div class="patient-box">
        <p><strong>Nama Pasien:</strong> {{ $selectedPatient->name }} ({{ strtoupper($selectedPatient->type ?? 'UMUM') }})</p>
        <p><strong>Kode Pasien:</strong> {{ $selectedPatient->code }} @if($selectedPatient->nik) | <strong>NIK:</strong> {{ $selectedPatient->nik }} @endif</p>
        <p>
            <strong>Periode:</strong>
            {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d F Y') : 'Semua' }}
            s/d
            {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d F Y') : 'Sekarang' }}
            | <strong>Total Pemeriksaan:</strong> {{ $records->count() }} kali
        </p>
    </div>

    @if(isset($mcuRecommendations) && $mcuRecommendations->isNotEmpty())
    <table>
        <thead>
            <tr>
                <th style="width: 28%;">Saran Bagian MCU</th>
                <th style="width: 36%;">Pemeriksaan yang Dianjurkan</th>
                <th style="width: 24%;">Diagnosa Terkait</th>
                <th style="width: 12%;">Kejadian</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mcuRecommendations as $mcu)
            <tr>
                <td><strong>{{ $mcu['category'] }}</strong></td>
                <td>{{ $mcu['exams'] }}</td>
                <td>
                    @foreach($mcu['diagnoses'] as $diagLabel => $diagCount)
                        {{ $diagLabel }} ({{ $diagCount }}x){{ !$loop->last ? ', ' : '' }}
                    @endforeach
                </td>
                <td class="text-center"><strong>{{ $mcu['count'] }}x</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 14%;">Tanggal & Jam</th>
                <th style="width: 12%;">No. RM</th>
                <th style="width: 18%;">Keluhan Utama</th>
                <th style="width: 22%;">Diagnosa (ICD-10)</th>
                <th style="width: 16%;">Tindakan</th>
                <th style="width: 14%;">Dokter</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $index => $rm)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    {{ $rm->created_at->format('d/m/Y') }}<br>
                    <small>{{ $rm->created_at->format('H:i') }} WIB</small>
                </td>
                <td>{{ $rm->code }}</td>
                <td>{{ $rm->keluhan_utama ?? '-' }}</td>
                <td>
                    @if($rm->diagnosis)
                        <strong>{{ $rm->diagnosis->code ?? '-' }}</strong> - {{ $rm->diagnosis->name }}
                    @else
                        {{ $rm->diagnosa ?? '-' }}
                    @endif
                </td>
                <td>{{ $rm->tindakan ?? '-' }}</td>
                <td>{{ $rm->doctor->name ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Belum ada riwayat pemeriksaan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada {{ now()->format('d F Y H:i') }} WIB
    </div>
</body>
</html>
