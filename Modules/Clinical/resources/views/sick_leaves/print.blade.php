<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Surat Sakit - {{ $letter->reg_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background-color: white !important; }
            @page { margin: 0; size: A4 portrait; }
        }
        body { font-family: 'Times New Roman', Times, serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex justify-center p-8 text-black">

    {{-- Kertas A4 --}}
    <div class="bg-white w-[210mm] min-h-[148mm] p-10 shadow-lg relative">
        
        {{-- Tombol Print Floating (Akan hilang saat diprint) --}}
        <div class="absolute top-4 right-4 no-print flex gap-2">
            <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded font-sans font-bold shadow hover:bg-blue-700">
                🖨️ Cetak Sekarang
            </button>
            <button onclick="window.close()" class="bg-gray-500 text-white px-4 py-2 rounded font-sans font-bold shadow hover:bg-gray-600">
                Tutup
            </button>
        </div>

        {{-- 1. KOP SURAT (Sesuaikan dengan Klinik Anda) --}}
        <div class="flex items-center border-b-2 border-black pb-4 mb-6">
            {{-- Logo (Ganti src logo Anda) --}}
            {{-- <img src="{{ asset('logo.png') }}" class="h-20 w-auto mr-4"> --}}
            <div class="header">
        <h1>Poliklinik PT. Nusantara Building Industries</h1>
        <p>Jl. Raya Semarang - Demak KM. 17, Wonokerto, Karangtengah, Demak, Jawa Tengah, Indonesia</p>
        <p>Telp: (0291) 686050 | Email: marketing@nusaboard.co.id</p>
    </div>
        </div>

        {{-- 2. JUDUL SURAT --}}
        <div class="text-center mb-8">
            <h2 class="text-xl font-bold underline decoration-2 underline-offset-4">SURAT KETERANGAN DOKTER</h2>
            <p class="text-sm mt-1">Nomor: {{ $letter->reg_number }}</p>
        </div>

        {{-- 3. ISI SURAT --}}
        <div class="text-justify leading-relaxed text-lg">
            <p class="mb-4">Yang bertanda tangan di bawah ini, menerangkan bahwa:</p>

            <table class="w-full mb-6 ml-4">
                <tr>
                    <td class="w-32 py-1">Nama</td>
                    <td class="w-4">:</td>
                    <td class="font-bold">{{ $letter->patient->name }}</td>
                </tr>
                <tr>
                    <td class="py-1">NIK / ID</td>
                    <td>:</td>
                    <td>{{ $letter->patient->nik ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="py-1">Departemen</td>
                    <td>:</td>
                    <td>{{ $letter->patient->department->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="py-1">Bagian</td>
                    <td>:</td>
                    <td>{{ $letter->patient->subDepartment->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="py-1">Umur</td>
                    <td>:</td>
                    <td>{{ \Carbon\Carbon::parse($letter->patient->birth_date)->age }} Tahun</td>
                </tr>
            </table>

            <p class="mb-4">
                Berdasarkan hasil pemeriksaan medis yang dilakukan pada tanggal <strong>{{ \Carbon\Carbon::parse($letter->created_at)->translatedFormat('d F Y') }}</strong>, 
                yang bersangkutan dinyatakan dalam keadaan <strong>SAKIT</strong>.
            </p>

            <p class="mb-6">
                Oleh karena itu, kepada yang bersangkutan perlu diberikan istirahat selama 
                <strong>{{ $letter->duration_days }} ({{ Terbilang($letter->duration_days) }}) hari</strong>, 
                terhitung mulai tanggal 
                <strong>{{ \Carbon\Carbon::parse($letter->start_date)->translatedFormat('d F Y') }}</strong> 
                sampai dengan tanggal 
                <strong>{{ \Carbon\Carbon::parse($letter->end_date)->translatedFormat('d F Y') }}</strong>.
            </p>

            <p class="mb-4">
                Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.
            </p>
            
            @if($letter->notes)
            <div class="mt-4 p-2 border border-dashed border-gray-400 text-sm italic">
                <strong>Catatan Medis:</strong> {{ $letter->notes }}
            </div>
            @endif
        </div>

        {{-- 4. TANDA TANGAN --}}
        <div class="flex justify-end mt-12">
            <div class="text-center w-64">
                <p class="mb-20">
                    Demak, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }} <br>
                    @if($letter->type == 'internal')
                        @if($letter->medicalRecord?->doctor_id)
                            Dokter Pemeriksa
                        @else
                            Perawat Pemeriksa
                        @endif
                    @else
                        Dokter Pemeriksa
                    @endif
                </p>
                
                <p class="font-bold underline text-lg">
                    @if($letter->type == 'internal')
                        @if($letter->medicalRecord?->doctor_id)
                            dr. {{ $letter->medicalRecord->doctor->name ?? '.....................' }}
                        @else
                            {{ $letter->medicalRecord->nurse->nama }}
                        @endif
                    @else
                        {{ $letter->external_doctor_name }}
                    @endif
                </p>
                <p class="text-xs">
                    SIP: {{ $letter->medicalRecord->examiner->sip_number ?? '-' }}
                </p>
            </div>
        </div>

    </div>
</body>
</html>

{{-- Helper function sederhana untuk terbilang angka kecil (opsional) --}}
@php
    function Terbilang($x) {
        $angka = ["Nol", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
        if ($x < 12) return $angka[$x];
        return $x; 
    }
@endphp