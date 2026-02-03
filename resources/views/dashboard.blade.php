<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Overview Operasional & Statistik Klinik</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-slate-500 mt-2 md:mt-0 dark:text-slate-400">
                <span class="text-slate-400 cursor-default">Home</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-blue-600 dark:text-blue-400">Dashboard</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
            
            <div>
                <h3 class="text-lg font-bold text-slate-700 mb-4 flex items-center dark:text-slate-300">
                    <span class="bg-blue-600 w-1.5 h-6 rounded-full mr-3"></span>
                    Aktivitas Hari Ini
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 text-white shadow-lg shadow-blue-500/20 relative overflow-hidden dark:shadow-none">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                        <div class="flex justify-between items-start relative z-10">
                            <div>
                                <p class="text-blue-100 font-medium mb-1 text-sm uppercase tracking-wider">Total Kunjungan</p>
                                <h4 class="text-4xl font-extrabold">{{ $stats['today_activity'] }}</h4>
                            </div>
                            <div class="p-2.5 bg-white/20 rounded-xl backdrop-blur-sm">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center text-xs font-medium text-blue-100 bg-blue-800/30 w-fit px-3 py-1 rounded-full">
                            Gabungan Poli Umum & Lab
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col justify-between hover:shadow-md">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-slate-500 dark:text-slate-400 font-medium mb-1 text-sm uppercase">Poli Umum</p>
                                <h4 class="text-3xl font-bold text-slate-800 dark:text-slate-100">{{ $stats['today_rm'] }}</h4>
                            </div>
                            <div class="p-3 bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
                            <div class="flex items-center text-xs text-green-600 dark:text-green-400 font-bold">
                                <span class="relative flex h-2 w-2 mr-2">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                </span>
                                Sedang Berlangsung
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col justify-between hover:shadow-md">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-slate-500 dark:text-slate-400 font-medium mb-1 text-sm uppercase">Cek Lab (POCT)</p>
                                <h4 class="text-3xl font-bold text-slate-800 dark:text-slate-100">{{ $stats['today_lab'] }}</h4>
                            </div>
                            <div class="p-3 bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
                            <div class="flex items-center text-xs text-purple-600 dark:text-purple-400 font-bold">
                                <span class="relative flex h-2 w-2 mr-2">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-purple-500"></span>
                                </span>
                                Sedang Berlangsung
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-bold text-slate-700 mb-4 flex items-center dark:text-slate-300">
                    <span class="bg-slate-500 w-1.5 h-6 rounded-full mr-3"></span>
                    Ringkasan Database
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @php
                        $dbCards = [
                            ['label' => 'Total Pasien', 'key' => 'total_patients', 'color' => 'blue', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                            ['label' => 'Total Dokter', 'key' => 'total_doctors', 'color' => 'indigo', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                            ['label' => 'Total Perawat', 'key' => 'total_nurses', 'color' => 'pink', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                            ['label' => 'Jenis Obat', 'key' => 'total_medicines', 'color' => 'emerald', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
                            ['label' => 'Arsip RM', 'key' => 'total_records', 'color' => 'cyan', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                            ['label' => 'Arsip Lab', 'key' => 'total_lab_logs', 'color' => 'violet', 'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                            ['label' => 'Data Penyakit', 'key' => 'total_diseases', 'color' => 'rose', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
                        ];
                    @endphp

                    @foreach($dbCards as $card)
                    <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm hover:border-{{ $card['color'] }}-300 dark:hover:border-{{ $card['color'] }}-500 group">
                        <div class="flex justify-between items-start mb-2">
                            <div class="p-2 bg-{{ $card['color'] }}-50 dark:bg-{{ $card['color'] }}-900/20 text-{{ $card['color'] }}-600 dark:text-{{ $card['color'] }}-400 rounded-lg group-hover:bg-{{ $card['color'] }}-600 dark:group-hover:bg-{{ $card['color'] }}-500 group-hover:text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"></path></svg>
                            </div>
                            <span class="text-2xl font-bold text-slate-800 dark:text-slate-100">{{ $stats[$card['key']] }}</span>
                        </div>
                        <div class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide">{{ $card['label'] }}</div>
                    </div>
                    @endforeach

                    <div class="bg-red-50 dark:bg-red-900/20 p-5 rounded-2xl border border-red-100 dark:border-red-900/40 shadow-sm hover:shadow-md group">
                        <div class="flex justify-between items-start mb-2">
                            <div class="p-2 bg-white dark:bg-slate-800 text-red-600 dark:text-red-400 rounded-lg shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <span class="text-2xl font-bold text-red-700 dark:text-red-400">{{ $criticalMedicines->count() }}</span>
                        </div>
                        <div class="text-xs font-bold text-red-600 dark:text-red-400 uppercase tracking-wide">Perlu Restock</div>
                    </div>

                </div>
            </div>

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