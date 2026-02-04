<!DOCTYPE html>
<html>
<head>
    <title>Hasil Lab - {{ $check->code }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 10px; }

        .meta-table { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .meta-table td { padding: 4px; vertical-align: top; }
        .label { font-weight: bold; width: 130px; }

        .result-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .result-table th, .result-table td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .result-table th { background-color: #f0f0f0; text-align: center; font-weight: bold; }
        .text-center { text-align: center; }
        
        .high { color: red; font-weight: bold; }
        .normal { color: green; }

        .footer { margin-top: 50px; width: 100%; }
        .ttd-box { float: right; text-align: center; width: 200px; }
        .ttd-space { height: 70px; }
        .notes-box { border: 1px dashed #ccc; padding: 10px; margin-top: 20px; background: #fafafa; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Poliklinik PT. Nusantara Building Industries</h1>
        <p>Jl. Raya Semarang - Demak KM. 17, Wonokerto, Karangtengah, Demak, Jawa Tengah, Indonesia</p>
        <p>Telp: (0291) 686050 | Email: marketing@nusaboard.co.id</p>
    </div>

    <div style="text-align: center; font-weight: bold; font-size: 16px; margin-bottom: 20px; text-decoration: underline;">
        HASIL PEMERIKSAAN LAB (STRIP)
    </div>

    <table class="meta-table">
        <tr>
            <td class="label">No. Transaksi</td>
            <td>: {{ $check->code }}</td>
            <td class="label">Tanggal Periksa</td>
            <td>: {{ $check->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td class="label">Nama Pasien</td>
            <td>: <strong>{{ $check->patient->name }}</strong></td>
            <td class="label">Usia / Gender</td>
            <td>: {{ \Carbon\Carbon::parse($check->patient->birth_date)->age }} Thn / {{ $check->patient->gender }}</td>
        </tr>
        <tr>
            <td class="label">{{$check->petugas_type}}</td>
            <td colspan="3">: {{ $check->petugas_name }}</td>
        </tr>
    </table>

    <table class="result-table">
        <thead>
            <tr>
                <th width="30%">Jenis Pemeriksaan</th>
                <th width="20%">Hasil</th>
                <th width="20%">Satuan</th>
                <th width="15%">Nilai Rujukan</th>
                <th width="15%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            
            @if($check->gula_darah)
            <tr>
                <td>Gula Darah Sewaktu (GDS)</td>
                <td class="text-center {{ $check->status_gula == 'danger' ? 'high' : '' }}">
                    {{ $check->gula_darah }}
                </td>
                <td class="text-center">mg/dL</td>
                <td class="text-center">&lt; 200</td>
                <td class="text-center {{ $check->status_gula == 'danger' ? 'high' : 'normal' }}">
                    {{ $check->status_gula == 'danger' ? 'TINGGI' : 'NORMAL' }}
                </td>
            </tr>
            @endif

            @if($check->kolesterol)
            <tr>
                <td>Kolesterol Total</td>
                <td class="text-center {{ $check->status_kolesterol == 'danger' ? 'high' : '' }}">
                    {{ $check->kolesterol }}
                </td>
                <td class="text-center">mg/dL</td>
                <td class="text-center">&lt; 200</td>
                <td class="text-center {{ $check->status_kolesterol == 'danger' ? 'high' : 'normal' }}">
                    {{ $check->status_kolesterol == 'danger' ? 'TINGGI' : 'NORMAL' }}
                </td>
            </tr>
            @endif

            @if($check->asam_urat)
            <tr>
                <td>Asam Urat</td>
                <td class="text-center {{ $check->status_asam_urat == 'danger' ? 'high' : '' }}">
                    {{ $check->asam_urat }}
                </td>
                <td class="text-center">mg/dL</td>
                <td class="text-center">
                    {{ $check->patient->gender == 'L' ? '< 7.0' : '< 6.0' }}
                </td>
                <td class="text-center {{ $check->status_asam_urat == 'danger' ? 'high' : 'normal' }}">
                    {{ $check->status_asam_urat == 'danger' ? 'TINGGI' : 'NORMAL' }}
                </td>
            </tr>
            @endif

            @if($check->tensi)
            <tr>
                <td>Tekanan Darah</td>
                <td class="text-center">{{ $check->tensi }}</td>
                <td class="text-center">mmHg</td>
                <td class="text-center">120/80</td>
                <td class="text-center">-</td>
            </tr>
            @endif

        </tbody>
    </table>

    @if($check->notes)
    <div class="notes-box">
        <strong>Catatan:</strong><br>
        {{ $check->notes }}
    </div>
    @endif

    <p style="font-style: italic; font-size: 10px; margin-top: 10px; color: #666;">
        * Pemeriksaan ini menggunakan metode POCT (Rapid Test/Stick). Untuk hasil yang lebih presisi, silakan lakukan konfirmasi dengan pemeriksaan laboratorium klinik lengkap.
    </p>

    <div class="footer">
        <div class="ttd-box">
            <p>{{$check->petugas_type}} Pemeriksa,</p>
            <div class="ttd-space"></div>
            <p style="text-decoration: underline; font-weight: bold;">
                {{ $check->petugas_name }}
            </p>
        </div>
    </div>

</body>
</html>