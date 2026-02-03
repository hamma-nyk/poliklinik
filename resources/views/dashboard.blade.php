<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Dashboard Utama') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Statistik Komprehensif Operasional Klinik</p>
            </div>
            <div class="hidden md:flex items-center text-[11px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">
                Data Terakhir diupdate: {{ date('H:i') }} WIB
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
            
            {{-- AKTIVITAS HARI INI (Highlight) --}}
            <section>
                <h3 class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-6 flex items-center">
                    <span class="bg-blue-600 w-1.5 h-5 rounded-full mr-3"></span>
                    Performa Hari Ini
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <a href="{{ route('clinical.records.index') }}" class="group bg-gradient-to-br from-indigo-600 to-blue-700 rounded-3xl p-8 text-white shadow-xl shadow-blue-500/20 relative overflow-hidden transition-all hover:scale-[1.02] active:scale-95 dark:shadow-none">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                        <div class="flex justify-between items-center relative z-10">
                            <div>
                                <p class="text-blue-100 font-bold mb-1 text-xs uppercase tracking-widest">Kunjungan Poli Umum</p>
                                <h4 class="text-5xl font-black">{{ $stats['today_rm'] }}</h4>
                                <p class="text-xs text-blue-200 mt-2 font-medium italic">*Klik untuk daftar pasien hari ini</p>
                            </div>
                            <div class="p-4 bg-white/20 rounded-2xl backdrop-blur-md border border-white/30 group-hover:bg-white/30 transition-colors">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('clinical.lab.index') }}" class="group bg-gradient-to-br from-purple-600 to-fuchsia-700 rounded-3xl p-8 text-white shadow-xl shadow-purple-500/20 relative overflow-hidden transition-all hover:scale-[1.02] active:scale-95 dark:shadow-none">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                        <div class="flex justify-between items-center relative z-10">
                            <div>
                                <p class="text-purple-100 font-bold mb-1 text-xs uppercase tracking-widest">Kunjungan Lab (POCT)</p>
                                <h4 class="text-5xl font-black">{{ $stats['today_lab'] }}</h4>
                                <p class="text-xs text-purple-200 mt-2 font-medium italic">*Klik untuk histori cek lab hari ini</p>
                            </div>
                            <div class="p-4 bg-white/20 rounded-2xl backdrop-blur-md border border-white/30 group-hover:bg-white/30 transition-colors">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            </div>
                        </div>
                    </a>
                </div>
            </section>

            {{-- TOTAL DATABASE --}}
            <section>
                <h3 class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-6 flex items-center">
                    <span class="bg-slate-400 w-1.5 h-5 rounded-full mr-3"></span>
                    Master Data & Inventaris
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    
                    {{-- Pasien - Blue --}}
    <x-dashboard-card 
        route="master.patients.index" 
        label="Pasien" 
        :count="$stats['total_patients']" 
        activeColor="hover:border-blue-400"
        bgColor="bg-blue-50 text-blue-600"
        darkBgColor="dark:bg-blue-900/20 dark:text-blue-400"
        hoverBg="group-hover:bg-blue-600"
        icon="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" 
    />

    {{-- Dokter - Indigo --}}
    <x-dashboard-card 
        route="master.doctors.index" 
        label="Dokter" 
        :count="$stats['total_doctors']" 
        activeColor="hover:border-indigo-400"
        bgColor="bg-indigo-50 text-indigo-600"
        darkBgColor="dark:bg-indigo-900/20 dark:text-indigo-400"
        hoverBg="group-hover:bg-indigo-600"
        icon="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" 
    />

    {{-- Perawat - Emerald --}}
    <x-dashboard-card 
        route="master.nurses.index" 
        label="Perawat" 
        :count="$stats['total_nurses']" 
        activeColor="hover:border-emerald-400"
        bgColor="bg-emerald-50 text-emerald-600"
        darkBgColor="dark:bg-emerald-900/20 dark:text-emerald-400"
        hoverBg="group-hover:bg-emerald-600"
        icon="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" 
    />

    {{-- Jenis Obat - Amber --}}
    <x-dashboard-card 
        route="inventory.medicines.index" 
        label="Jenis Obat" 
        :count="$stats['total_medicines']" 
        activeColor="hover:border-amber-400"
        bgColor="bg-amber-50 text-amber-600"
        darkBgColor="dark:bg-amber-900/20 dark:text-amber-400"
        hoverBg="group-hover:bg-amber-600"
        icon="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" 
    />

    {{-- Arsip RM - Cyan --}}
    <x-dashboard-card 
        route="clinical.records.index" 
        label="Arsip RM" 
        :count="$stats['total_records']" 
        activeColor="hover:border-cyan-400"
        bgColor="bg-cyan-50 text-cyan-600"
        darkBgColor="dark:bg-cyan-900/20 dark:text-cyan-400"
        hoverBg="group-hover:bg-cyan-600"
        icon="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" 
    />

    {{-- Arsip Lab - Violet --}}
    <x-dashboard-card 
        route="clinical.lab.index" 
        label="Arsip Lab" 
        :count="$stats['total_lab_logs'] ?? 0" 
        activeColor="hover:border-violet-400"
        bgColor="bg-violet-50 text-violet-600"
        darkBgColor="dark:bg-violet-900/20 dark:text-violet-400"
        hoverBg="group-hover:bg-violet-600"
        icon="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" 
    />
    
                    <a href="{{ route('inventory.medicines.index') }}" class="group bg-rose-50 dark:bg-rose-900/20 p-6 rounded-3xl border border-rose-100 dark:border-rose-900/40 shadow-sm hover:bg-rose-600 transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex justify-between items-center mb-4">
                            <div class="p-2 bg-white dark:bg-slate-800 text-rose-600 dark:text-rose-400 rounded-xl group-hover:bg-white/20 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <span class="text-3xl font-black text-rose-700 dark:text-rose-400 group-hover:text-white tracking-tighter">{{ $criticalMedicines->count() }}</span>
                        </div>
                        <div class="text-[10px] font-black text-rose-600 dark:text-rose-400 uppercase tracking-[0.1em] group-hover:text-rose-100">Stok Menipis</div>
                    </a>

                </div>
            </section>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 lg:col-span-2">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">Tren Kunjungan (7 Hari)</h3>
                    </div>
                    <div id="chart-visits"></div>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-6">Top 5 Diagnosa</h3>
                    <div id="chart-diseases"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pb-8">
                
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                    <div class="p-5 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/50">
                        <h3 class="font-bold text-slate-800 dark:text-slate-100">Pasien Terakhir</h3>
                        <a href="{{ route('clinical.records.index') }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:text-blue-800 flex items-center">
                            Lihat Semua <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                    <table class="w-full text-sm text-left">
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @forelse($latestRecords as $rec)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                                <td class="px-5 py-3">
                                    <div class="font-bold text-slate-800 dark:text-slate-200">{{ $rec->patient->name }}</div>
                                    <div class="text-xs text-slate-400 dark:text-slate-500 font-mono mt-0.5">{{ $rec->code }}</div>
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <span class="text-[10px] font-bold bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 px-2 py-1 rounded-full">
                                        {{ $rec->created_at->diffForHumans() }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="2" class="p-6 text-center text-slate-400 italic">Belum ada data kunjungan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                    <div class="p-5 border-b border-red-50 dark:border-red-900/30 flex justify-between items-center bg-red-50/30 dark:bg-red-900/20">
                        <div class="flex items-center">
                            <span class="w-2 h-2 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                            <h3 class="font-bold text-red-800 dark:text-red-400">Stok Obat Menipis (≤ 10)</h3>
                        </div>
                        <a href="{{ route('inventory.medicines.index') }}" class="text-xs font-bold text-red-600 dark:text-red-400 hover:text-red-800 hover:underline">Kelola</a>
                    </div>
                    <table class="w-full text-sm text-left">
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @forelse($criticalMedicines as $med)
                            <tr class="hover:bg-red-50/30 dark:hover:bg-red-900/10">
                                <td class="px-5 py-3">
                                    <div class="font-bold text-slate-800 dark:text-slate-200">{{ $med->name }}</div>
                                    <div class="text-xs text-slate-400 dark:text-slate-500 font-mono">{{ $med->code }}</div>
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <span class="bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400 px-2 py-1 rounded-lg text-xs font-bold border border-red-200 dark:border-red-800">
                                        Sisa: {{ $med->current_stock }} {{ $med->unit }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="2" class="p-6 text-center text-green-600 font-medium">Stok aman! Tidak ada yang kritis.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Helper to check dark mode
            const isDark = document.documentElement.classList.contains('dark');
            const gridColor = isDark ? '#334155' : '#f1f5f9';
            const labelColor = isDark ? '#94a3b8' : '#64748b';

            // 1. Chart Visits
            var optionsVisits = {
                chart: { type: 'area', height: 300, toolbar: { show: false }, fontFamily: 'inherit' },
                series: [{ name: 'Total Pasien', data: @json($chartVisits) }],
                xaxis: { 
                    categories: @json($chartDates),
                    labels: { style: { colors: labelColor, fontSize: '12px' } },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: { labels: { style: { colors: labelColor, fontSize: '12px' } } },
                colors: ['#3b82f6'],
                stroke: { curve: 'smooth', width: 3 },
                fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] } },
                dataLabels: { enabled: false },
                grid: { borderColor: gridColor, strokeDashArray: 4 },
                tooltip: { theme: isDark ? 'dark' : 'light' }
            };
            new ApexCharts(document.querySelector("#chart-visits"), optionsVisits).render();

            // 2. Chart Diseases
            var dataDisease = @json($chartDiseaseData);
            if(dataDisease.length > 0) {
                var optionsDiseases = {
                    chart: { type: 'donut', height: 320, fontFamily: 'inherit' },
                    series: dataDisease,
                    labels: @json($chartDiseaseLabels),
                    colors: ['#ef4444', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6'],
                    legend: { 
                        position: 'bottom', 
                        fontSize: '13px', 
                        labels: { colors: labelColor },
                        itemMargin: { horizontal: 10, vertical: 5 } 
                    },
                    plotOptions: { 
                        pie: { 
                            donut: { 
                                size: '65%', 
                                labels: { 
                                    show: true, 
                                    total: { 
                                        show: true, 
                                        label: 'Total', 
                                        fontSize: '14px', 
                                        fontWeight: 600, 
                                        color: labelColor 
                                    },
                                    value: { color: labelColor }
                                } 
                            } 
                        } 
                    },
                    stroke: { colors: [isDark ? '#1e293b' : '#ffffff'] },
                    dataLabels: { enabled: false },
                    tooltip: { theme: isDark ? 'dark' : 'light' }
                };
                new ApexCharts(document.querySelector("#chart-diseases"), optionsDiseases).render();
            } else {
                document.querySelector("#chart-diseases").innerHTML = `<div class='text-center text-slate-400 py-20 italic bg-slate-50 dark:bg-slate-800/50 rounded-xl'>Belum ada data diagnosa.</div>`;
            }
        });
    </script>
</x-app-layout>