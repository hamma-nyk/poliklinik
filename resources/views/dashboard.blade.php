<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">Statistik Komprehensif Operasional Klinik</p>
            </div>
            <div class="hidden md:flex items-center text-xs text-neutral-500 dark:text-neutral-400">
                <span class="relative flex h-2 w-2 mr-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                Sistem Online: {{ date('H:i') }} WIB
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- AKTIVITAS HARI INI (Highlight) --}}
            <section class="space-y-4">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
                    <h3 class="text-lg font-medium tracking-tight">Performa Klinis</h3>
                    <form action="{{ route('dashboard') }}" method="GET" class="flex items-center space-x-2">
                        <select name="month" onchange="this.form.submit()" class="flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-neutral-200 bg-transparent px-3 py-2 text-sm shadow-sm ring-offset-white placeholder:text-neutral-500 focus:outline-none focus:ring-1 focus:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:ring-offset-neutral-950 dark:placeholder:text-neutral-400 dark:focus:ring-neutral-300">
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                        <select name="year" onchange="this.form.submit()" class="flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-neutral-200 bg-transparent px-3 py-2 text-sm shadow-sm ring-offset-white placeholder:text-neutral-500 focus:outline-none focus:ring-1 focus:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:ring-offset-neutral-950 dark:placeholder:text-neutral-400 dark:focus:ring-neutral-300">
                            @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </form>
                </div>
                
                <div class="grid gap-4 md:grid-cols-2">
                    <a href="{{ route('clinical.records.index') }}" class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 transition-all hover:bg-neutral-50 dark:hover:bg-neutral-700 group">
                        <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 class="tracking-tight text-sm font-medium">Kunjungan Poli Umum</h3>
                            <svg class="h-4 w-4 text-neutral-500 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="text-2xl font-bold">{{ $stats['today_rm'] }}</div>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Hari ini</p>
                        </div>
                    </a>

                    <a href="{{ route('clinical.lab.index') }}" class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 transition-all hover:bg-neutral-50 dark:hover:bg-neutral-700 group">
                        <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 class="tracking-tight text-sm font-medium">Kunjungan Lab (POCT)</h3>
                            <svg class="h-4 w-4 text-neutral-500 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="text-2xl font-bold">{{ $stats['today_lab'] }}</div>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Hari ini</p>
                        </div>
                    </a>
                </div>
            </section>

            {{-- TOTAL DATABASE --}}
            <section class="space-y-4">
                <h3 class="text-lg font-medium tracking-tight">Master Data</h3>
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <x-dashboard-card route="master.patients.index" label="Total Pasien" :count="$stats['total_patients']" icon="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" activeColor="" bgColor="" darkBgColor="" hoverBg=""/>
                    <x-dashboard-card route="master.doctors.index" label="Total Dokter" :count="$stats['total_doctors']" icon="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" activeColor="" bgColor="" darkBgColor="" hoverBg=""/>
                    <x-dashboard-card route="master.nurses.index" label="Total Perawat" :count="$stats['total_nurses']" icon="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" activeColor="" bgColor="" darkBgColor="" hoverBg=""/>
                    <x-dashboard-card route="inventory.medicines.index" label="Jenis Obat" :count="$stats['total_medicines']" icon="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" activeColor="" bgColor="" darkBgColor="" hoverBg=""/>
                </div>
            </section>

            {{-- RINGKASAN DATA (Extra Cards) --}}
            <section class="space-y-4">
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    {{-- K3 --}}
                    <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50">
                        <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 class="tracking-tight text-sm font-medium">Total Insiden K3</h3>
                            <svg class="h-4 w-4 text-neutral-500 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="text-2xl font-bold">{{ $kecelakaanCount }}</div>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Bulan ini</p>
                        </div>
                    </div>

                    {{-- Stok Menipis --}}
                    <a href="{{ route('inventory.medicines.index') }}" class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 transition-all hover:bg-neutral-50 dark:hover:bg-neutral-700 group">
                        <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 class="tracking-tight text-sm font-medium">Stok Menipis (≤10)</h3>
                            <svg class="h-4 w-4 text-neutral-500 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="text-2xl font-bold text-destructive">{{ $criticalMedicines->count() }}</div>
                        </div>
                    </a>

                    {{-- Arsip RM --}}
                    <a href="{{ route('clinical.records.index') }}" class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 transition-all hover:bg-neutral-50 dark:hover:bg-neutral-700 group">
                        <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 class="tracking-tight text-sm font-medium">Total Arsip RM</h3>
                            <svg class="h-4 w-4 text-neutral-500 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="text-2xl font-bold">{{ $stats['total_records'] }}</div>
                        </div>
                    </a>

                    {{-- Arsip Lab --}}
                    <a href="{{ route('clinical.lab.index') }}" class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 transition-all hover:bg-neutral-50 dark:hover:bg-neutral-700 group">
                        <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 class="tracking-tight text-sm font-medium">Total Arsip Lab</h3>
                            <svg class="h-4 w-4 text-neutral-500 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="text-2xl font-bold">{{ $stats['total_lab_logs'] ?? 0 }}</div>
                        </div>
                    </a>
                </div>
            </section>

            {{-- CHARTS --}}
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-7">
                <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 lg:col-span-4">
                    <div class="flex flex-col space-y-1.5 p-6">
                        <h3 class="font-semibold leading-none tracking-tight">Tren Kunjungan Harian</h3>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">Bulan {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}</p>
                    </div>
                    <div class="p-6 pt-0">
                        <div id="chart-trend-daily" class="min-h-[300px]"></div>
                    </div>
                </div>

                <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 lg:col-span-3">
                    <div class="flex flex-col space-y-1.5 p-6">
                        <h3 class="font-semibold leading-none tracking-tight">Proporsi Kunjungan K3</h3>
                    </div>
                    <div class="p-6 pt-0">
                        <div id="chart-visit-types" class="min-h-[250px] flex justify-center"></div>
                        <div class="grid grid-cols-2 gap-4 mt-4 text-center">
                            <div>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400">Sakit (Umum)</p>
                                <p class="text-2xl font-bold">{{ $sakitCount }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400">Kecelakaan Kerja</p>
                                <p class="text-2xl font-bold">{{ $kecelakaanCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TOP 5 DIAGNOSA --}}
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50">
                <div class="flex flex-col space-y-1.5 p-6 border-b border-neutral-200 dark:border-neutral-600">
                    <h3 class="font-semibold leading-none tracking-tight">Top 5 Diagnosa</h3>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Penyakit terbanyak bulan ini</p>
                </div>
                <div class="p-0">
                    <div class="relative w-full overflow-auto">
                        <table class="w-full caption-bottom text-sm">
                            <thead class="[&_tr]:border-b">
                                <tr class="border-b border-neutral-200 transition-colors dark:border-neutral-600">
                                    <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">No</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Diagnosa</th>
                                    <th class="h-12 px-4 text-right align-middle font-medium text-neutral-500 dark:text-neutral-400">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="[&_tr:last-child]:border-0">
                                @php $diagLabelsArr = $diagLabels ?? []; $diagDataArr = $diagData ?? []; @endphp
                                @forelse($diagLabelsArr as $i => $label)
                                <tr class="border-b border-neutral-200 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                    <td class="p-4 align-middle text-neutral-500 dark:text-neutral-400">{{ $i + 1 }}</td>
                                    <td class="p-4 align-middle font-medium">{{ $label }}</td>
                                    <td class="p-4 align-middle text-right">
                                        <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors border-neutral-200 text-neutral-950 dark:border-neutral-600 dark:text-neutral-50">
                                            {{ $diagDataArr[$i] ?? 0 }}
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="p-4 text-center text-sm text-neutral-500">Belum ada data diagnosa.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- TABLES --}}
            <div class="grid gap-4 md:grid-cols-2">
                
                {{-- Recent Patients --}}
                <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50">
                    <div class="flex flex-col space-y-1.5 p-6 border-b border-neutral-200 dark:border-neutral-600">
                        <div class="flex justify-between items-center">
                            <h3 class="font-semibold leading-none tracking-tight">Pasien Terakhir</h3>
                            <a href="{{ route('clinical.records.index') }}" class="text-xs font-medium text-neutral-500 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-50">
                                Lihat Semua
                            </a>
                        </div>
                    </div>
                    <div class="p-0">
                        <div class="relative w-full overflow-auto">
                            <table class="w-full caption-bottom text-sm">
                                <tbody class="[&_tr:last-child]:border-0">
                                    @forelse($latestRecords as $rec)
                                    <tr class="border-b border-neutral-200 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                        <td class="p-4 align-middle">
                                            <div class="font-medium">{{ $rec->patient->name }}</div>
                                            <div class="text-xs text-neutral-500 dark:text-neutral-400">{{ $rec->code }}</div>
                                        </td>
                                        <td class="p-4 align-middle text-right">
                                            <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors border-neutral-200 text-neutral-950 dark:border-neutral-600 dark:text-neutral-50">
                                                {{ $rec->created_at->format('H:i') }}
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="2" class="p-4 text-center text-sm text-neutral-500">Belum ada data kunjungan.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Critical Stock --}}
                <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50">
                    <div class="flex flex-col space-y-1.5 p-6 border-b border-neutral-200 dark:border-neutral-600">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <h3 class="font-semibold leading-none tracking-tight text-destructive">Stok Obat Menipis (≤ 10)</h3>
                            </div>
                            <a href="{{ route('inventory.medicines.index') }}" class="text-xs font-medium text-destructive hover:text-destructive/80">
                                Kelola Stok
                            </a>
                        </div>
                    </div>
                    <div class="p-0">
                        <div class="relative w-full overflow-auto">
                            <table class="w-full caption-bottom text-sm">
                                <tbody class="[&_tr:last-child]:border-0">
                                    @forelse($criticalMedicines as $med)
                                    <tr class="border-b border-neutral-200 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                        <td class="p-4 align-middle">
                                            <div class="font-medium">{{ $med->name }}</div>
                                            <div class="text-xs text-neutral-500 dark:text-neutral-400">{{ $med->code }}</div>
                                        </td>
                                        <td class="p-4 align-middle text-right">
                                            <div class="inline-flex items-center rounded-md border border-transparent bg-destructive/10 text-destructive px-2.5 py-0.5 text-xs font-semibold">
                                                {{ $med->current_stock }} {{ $med->unit }}
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="2" class="p-4 text-center text-sm text-neutral-500">Stok aman.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#fafafa' : '#171717';
            const mutedColor = isDark ? '#a3a3a3' : '#525252';
            const gridColor = isDark ? '#262626' : '#f5f5f5';

            var optionsTrend = {
                series: [{ name: "Kunjungan", data: @json($trendData) }],
                chart: {
                    height: 300,
                    type: 'area',
                    toolbar: { show: false },
                    fontFamily: 'inherit',
                    background: 'transparent'
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2, colors: ['#171717'] },
                xaxis: {
                    categories: @json($trendLabels),
                    labels: { style: { colors: mutedColor } },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: { labels: { style: { colors: mutedColor } } },
                grid: { borderColor: gridColor, strokeDashArray: 4 },
                theme: { mode: isDark ? 'dark' : 'light' },
                fill: {
                    type: 'gradient',
                    gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.1, stops: [0, 100] },
                    colors: ['#171717']
                }
            };
            if(document.querySelector("#chart-trend-daily")) {
                new ApexCharts(document.querySelector("#chart-trend-daily"), optionsTrend).render();
            }

            var optionsDonut = {
                series: [{{ $sakitCount }}, {{ $kecelakaanCount }}],
                labels: ['Sakit Umum', 'Kecelakaan Kerja'],
                chart: { type: 'donut', height: 250, fontFamily: 'inherit', background: 'transparent' },
                colors: ['#171717', '#ef4444'],
                dataLabels: { enabled: false },
                legend: { show: false },
                stroke: { width: 0 },
                plotOptions: { pie: { donut: { size: '75%' } } },
                theme: { mode: isDark ? 'dark' : 'light' }
            };
            if(document.querySelector("#chart-visit-types")) {
                new ApexCharts(document.querySelector("#chart-visit-types"), optionsDonut).render();
            }


        });
    </script>
</x-app-layout>