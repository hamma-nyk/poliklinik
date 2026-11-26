<x-app-layout title="Laporan Rekam Medis Pasien">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight leading-tight">
                    {{ __('Rekam Medis Pasien') }}
                </h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">Riwayat tanggal pemeriksaan & diagnosa tiap pasien</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                <a href="{{ route('clinical.reports.index') }}" class="hover:text-neutral-900 dark:hover:text-neutral-50 transition-colors">Laporan</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Rekam Medis Pasien</span>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="w-full space-y-6">

            {{-- Filter Panel --}}
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-4">
                <form method="GET" action="{{ route('clinical.reports.patient_records') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    <div class="md:col-span-5 space-y-1.5">
                        <label class="text-sm font-medium leading-none">Pilih Pasien</label>
                        <div>
                            <select name="patient_id" class="tom-select w-full" required>
                                <option value="">-- Cari Nama / Kode / NIK Pasien --</option>
                                @foreach($patients as $p)
                                    <option value="{{ $p->id }}" {{ request('patient_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->name }} ({{ $p->code }}){{ $p->nik ? ' - ' . $p->nik : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="md:col-span-2 space-y-1.5">
                        <label class="text-sm font-medium leading-none">Dari Tanggal <span class="text-xs font-normal text-neutral-400">(Opsional)</span></label>
                        <input type="date" name="start_date" value="{{ $startDate }}"
                            class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 dark:border-neutral-600 dark:focus-visible:ring-neutral-300">
                    </div>

                    <div class="md:col-span-2 space-y-1.5">
                        <label class="text-sm font-medium leading-none">Sampai Tanggal <span class="text-xs font-normal text-neutral-400">(Opsional)</span></label>
                        <input type="date" name="end_date" value="{{ $endDate }}"
                            class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 dark:border-neutral-600 dark:focus-visible:ring-neutral-300">
                    </div>

                    <div class="md:col-span-3 flex flex-wrap gap-2">
                        <a href="{{ route('clinical.reports.index') }}"
                           class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-3 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50" title="Kembali">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </a>
                        <button type="submit" name="action" value="filter"
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-4 dark:bg-neutral-50 dark:text-neutral-900 dark:hover:bg-neutral-50/90 flex-1">
                            Tampilkan
                        </button>
                        @if($selectedPatient)
                        <button type="submit" name="action" value="excel" formtarget="_blank"
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-3 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50" title="Export Excel">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                        </button>
                        <button type="submit" name="action" value="pdf" formtarget="_blank"
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-3 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50" title="Export PDF">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        </button>
                        @endif
                    </div>
                </form>
            </div>

            @if($selectedPatient)
                {{-- Saran MCU Berdasarkan Riwayat Diagnosa --}}
                @if($mcuRecommendations->isNotEmpty())
                <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 overflow-hidden">
                    <div class="p-4 sm:px-6 border-b border-neutral-200 dark:border-neutral-600 bg-neutral-50/50 dark:bg-neutral-800/50 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <h3 class="text-sm font-semibold uppercase tracking-wider">Saran MCU (Medical Check-Up) Berdasarkan Riwayat Diagnosa</h3>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Rekomendasi bagian pemeriksaan lanjutan beserta jumlah kejadian yang pernah tercatat</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 rounded-md font-medium text-xs border border-amber-200 dark:border-amber-800/50">
                            {{ $mcuRecommendations->count() }} Bagian Disarankan
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full caption-bottom text-sm">
                            <thead>
                                <tr class="border-b border-neutral-200 dark:border-neutral-600">
                                    <th class="h-11 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Bagian MCU Disarankan</th>
                                    <th class="h-11 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Pemeriksaan yang Dianjurkan</th>
                                    <th class="h-11 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Riwayat Diagnosa Terkait</th>
                                    <th class="h-11 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400 w-36">Jumlah Kejadian</th>
                                </tr>
                            </thead>
                            <tbody class="[&_tr:last-child]:border-0">
                                @foreach($mcuRecommendations as $mcu)
                                <tr class="border-b border-neutral-200 dark:border-neutral-600">
                                    <td class="p-4 align-middle font-semibold text-neutral-900 dark:text-neutral-100">
                                        {{ $mcu['category'] }}
                                    </td>
                                    <td class="p-4 align-middle text-xs text-neutral-600 dark:text-neutral-300">
                                        {{ $mcu['exams'] }}
                                    </td>
                                    <td class="p-4 align-middle">
                                        <div class="flex flex-wrap gap-1.5">
                                            @foreach($mcu['diagnoses'] as $diagLabel => $diagCount)
                                                <span class="inline-flex items-center rounded-md border border-neutral-200 dark:border-neutral-600 bg-neutral-50 dark:bg-neutral-700/60 px-2 py-0.5 text-xs">
                                                    {{ $diagLabel }} <strong class="ml-1">({{ $diagCount }}x)</strong>
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="p-4 align-middle text-center whitespace-nowrap">
                                        <span class="inline-flex items-center rounded-md bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800/50 px-3 py-1 text-xs font-bold">
                                            {{ $mcu['count'] }} Kejadian
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                {{-- Ringkasan Pasien --}}
                <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 overflow-hidden">
                    <div class="p-4 sm:p-6 border-b border-neutral-200 dark:border-neutral-600 bg-neutral-50/50 dark:bg-neutral-800/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md border border-neutral-200 bg-neutral-100 text-sm font-semibold dark:border-neutral-600 dark:bg-neutral-700">
                                {{ strtoupper(substr($selectedPatient->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h3 class="text-base font-semibold">{{ $selectedPatient->name }}</h3>
                                    <span class="inline-flex items-center rounded-md border border-neutral-200 dark:border-neutral-600 px-2 py-0.5 text-[10px] font-semibold uppercase">
                                        {{ $selectedPatient->type ?? 'UMUM' }}
                                    </span>
                                </div>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                                    Kode: <span class="font-mono">{{ $selectedPatient->code }}</span>
                                    @if($selectedPatient->nik) · NIK: <span class="font-mono">{{ $selectedPatient->nik }}</span> @endif
                                    @if($startDate || $endDate)
                                        · Periode: {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d M Y') : 'Awal' }} — {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d M Y') : 'Sekarang' }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-3 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-md font-medium text-xs border border-blue-200 dark:border-blue-800/50">
                                Total Pemeriksaan: {{ $records->count() }}x
                            </span>
                            <span class="inline-flex items-center px-3 py-1 bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-200 rounded-md font-medium text-xs border border-neutral-200 dark:border-neutral-600">
                                Diagnosa Unik: {{ $records->pluck('diagnosis_id')->filter()->unique()->count() }}
                            </span>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full caption-bottom text-sm">
                            <thead class="[&_tr]:border-b">
                                <tr class="border-b border-neutral-200 dark:border-neutral-600">
                                    <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400 w-12">No</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Tanggal & No. RM</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Keluhan Utama</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Diagnosa (ICD-10)</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Tindakan & Vital</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Pemeriksa</th>
                                    <th class="h-12 px-4 text-right align-middle font-medium text-neutral-500 dark:text-neutral-400">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="[&_tr:last-child]:border-0">
                                @forelse($records as $index => $rm)
                                <tr class="border-b border-neutral-200 transition-colors dark:border-neutral-600">
                                    <td class="p-4 align-middle text-neutral-500 dark:text-neutral-400">{{ $index + 1 }}</td>
                                    <td class="p-4 align-middle whitespace-nowrap">
                                        <div class="font-semibold text-neutral-900 dark:text-neutral-100">{{ $rm->created_at->format('d M Y') }}</div>
                                        <div class="text-xs text-neutral-500 dark:text-neutral-400">{{ $rm->created_at->format('H:i') }} WIB</div>
                                        <span class="inline-flex items-center rounded-md border border-neutral-200 dark:border-neutral-600 bg-neutral-50 dark:bg-neutral-800 px-2 py-0.5 text-[11px] font-mono font-semibold mt-1">
                                            {{ $rm->code }}
                                        </span>
                                    </td>
                                    <td class="p-4 align-middle max-w-xs">
                                        <p class="text-sm text-neutral-700 dark:text-neutral-300">{{ $rm->keluhan_utama ?? '-' }}</p>
                                    </td>
                                    <td class="p-4 align-middle">
                                        @if($rm->diagnosis)
                                            <div class="font-semibold text-neutral-900 dark:text-neutral-100">{{ $rm->diagnosis->name }}</div>
                                            <span class="inline-flex items-center rounded-md border border-neutral-200 dark:border-neutral-600 px-2 py-0.5 text-[11px] font-mono font-semibold mt-1">
                                                {{ $rm->diagnosis->code ?? '-' }}
                                            </span>
                                        @elseif($rm->diagnosa)
                                            <div class="font-medium text-neutral-800 dark:text-neutral-200">{{ $rm->diagnosa }}</div>
                                        @else
                                            <span class="text-neutral-400">-</span>
                                        @endif
                                    </td>
                                    <td class="p-4 align-middle">
                                        <div class="text-sm text-neutral-700 dark:text-neutral-300">{{ $rm->tindakan ?? '-' }}</div>
                                        @if($rm->tensi || $rm->suhu_tubuh)
                                            <div class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                                                @if($rm->tensi) TD: {{ $rm->tensi }} @endif
                                                @if($rm->tensi && $rm->suhu_tubuh) · @endif
                                                @if($rm->suhu_tubuh) Suhu: {{ $rm->suhu_tubuh }}°C @endif
                                            </div>
                                        @endif
                                    </td>
                                    <td class="p-4 align-middle whitespace-nowrap">
                                        <div class="text-sm font-medium">{{ $rm->doctor->name ?? '-' }}</div>
                                        @if($rm->nurse)
                                            <div class="text-xs text-neutral-500 dark:text-neutral-400">Perawat: {{ $rm->nurse->name }}</div>
                                        @endif
                                    </td>
                                    <td class="p-4 align-middle text-right whitespace-nowrap">
                                        <a href="{{ route('clinical.records.show', $rm->id) }}"
                                           class="inline-flex items-center justify-center rounded-md border border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3 py-1.5 text-xs font-medium hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors">
                                            Detail RM
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-neutral-500 dark:text-neutral-400">
                                        Pasien ini belum memiliki riwayat pemeriksaan pada periode yang dipilih.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-12 text-center">
                    <div class="mx-auto w-12 h-12 rounded-full bg-neutral-100 dark:bg-neutral-700 flex items-center justify-center text-neutral-500 dark:text-neutral-400 mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h3 class="text-sm font-medium">Pilih Pasien Terlebih Dahulu</h3>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Pilih nama pasien di atas lalu klik <strong>Tampilkan</strong> untuk melihat riwayat pemeriksaan dan diagnosanya.</p>
                </div>
            @endif

        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.tom-select').forEach((el) => {
                new TomSelect(el, {
                    create: false,
                    sortField: { field: "text", order: "asc" }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
