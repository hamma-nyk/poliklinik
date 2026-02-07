<!DOCTYPE html>
<html>
<head>
    <title>Laporan SKD</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 4px; text-align: left; vertical-align: top; }
        th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .badge { padding: 2px 4px; border-radius: 3px; font-size: 8px; color: white; }
        .bg-int { background-color: #4f46e5; }
        .bg-ext { background-color: #ea580c; }
    </style>
</head>
<body>

    <div class="header">
        <h2>LAPORAN SURAT KETERANGAN DOKTER (SKD)</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama Pasien</th>
                <th>Dept / Jabatan</th>
                <th>No. SKD</th>
                <th>Mulai</th>
                <th>Akhir</th>
                <th>Dokter</th>
                <th>Perawat</th>
                <th>RSUD/Poli</th>
                <th>Diagnosa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $row)
            @php
                // Logic Mapping View (Sama seperti Excel)
                $dokter = '-'; $perawat = '-'; $klinik = $row->external_clinic_name; $diagnosa = $row->notes;
                
                if($row->type == 'internal') {
                    $klinik = 'Klinik Internal';
                    $examiner = $row->medicalRecord->examiner ?? null;
                    if ($examiner) {
                        if (str_contains(get_class($examiner), 'Doctor')) {
                            $dokter = $examiner->name;
                        } else {
                            $perawat = $examiner->nama ?? $examiner->name;
                        }
                    }
                } else {
                    $dokter = $row->external_doctor_name;
                }
            @endphp
            <tr>
                <td style="text-align: center">{{ $key + 1 }}</td>
                <td>{{ $row->patient->nik }}</td>
                <td>
                    <b>{{ $row->patient->name }}</b><br>
                    <span style="color: #666">KTP: {{ $row->patient->ktp ?? '-' }}</span>
                </td>
                <td>{{ $row->patient->department }}<br>{{ $row->patient->position }}</td>
                <td>
                    {{ $row->reg_number }} <br>
                    @if($row->type == 'internal')
                        <span class="badge bg-int">Internal</span>
                    @else
                        <span class="badge bg-ext">Eksternal</span>
                    @endif
                </td>
                <td>{{ $row->start_date }}</td>
                <td>{{ $row->end_date }}</td>
                <td>{{ $dokter }}</td>
                <td>{{ $perawat }}</td>
                <td>{{ $klinik }}</td>
                <td>{{ $diagnosa }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>