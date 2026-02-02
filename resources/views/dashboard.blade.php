<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Overview Operasional & Statistik Klinik</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-slate-500 mt-2 md:mt-0">
                <span class="text-slate-400 cursor-default">Home</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-blue-600">Dashboard</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
            
            <div>
                <h3 class="text-lg font-bold text-slate-700 mb-4 flex items-center">
                    <span class="bg-blue-600 w-1.5 h-6 rounded-full mr-3"></span>
                    Aktivitas Hari Ini
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <div class="bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl p-6 text-white shadow-lg shadow-blue-500/20 relative overflow-hidden">
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

                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-slate-500 font-medium mb-1 text-sm uppercase">Poli Umum</p>
                                <h4 class="text-3xl font-bold text-slate-800">{{ $stats['today_rm'] }}</h4>
                            </div>
                            <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-slate-100">
                            <div class="flex items-center text-xs text-green-600 font-bold">
                                <span class="relative flex h-2 w-2 mr-2">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                </span>
                                Sedang Berlangsung
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-slate-500 font-medium mb-1 text-sm uppercase">Cek Lab (POCT)</p>
                                <h4 class="text-3xl font-bold text-slate-800">{{ $stats['today_lab'] }}</h4>
                            </div>
                            <div class="p-3 bg-purple-50 text-purple-600 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-slate-100">
                            <div class="flex items-center text-xs text-purple-600 font-bold">
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
                <h3 class="text-lg font-bold text-slate-700 mb-4 flex items-center">
                    <span class="bg-slate-500 w-1.5 h-6 rounded-full mr-3"></span>
                    Ringkasan Database
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-blue-300 transition-colors group">
                        <div class="flex justify-between items-start mb-2">
                            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <span class="text-2xl font-bold text-slate-800">{{ $stats['total_patients'] }}</span>
                        </div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wide">Total Pasien</div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-indigo-300 transition-colors group">
                        <div class="flex justify-between items-start mb-2">
                            <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <span class="text-2xl font-bold text-slate-800">{{ $stats['total_doctors'] }}</span>
                        </div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wide">Total Dokter</div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-pink-300 transition-colors group">
                        <div class="flex justify-between items-start mb-2">
                            <div class="p-2 bg-pink-50 text-pink-600 rounded-lg group-hover:bg-pink-600 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </div>
                            <span class="text-2xl font-bold text-slate-800">{{ $stats['total_nurses'] }}</span>
                        </div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wide">Total Perawat</div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-emerald-300 transition-colors group">
                        <div class="flex justify-between items-start mb-2">
                            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            </div>
                            <span class="text-2xl font-bold text-slate-800">{{ $stats['total_medicines'] }}</span>
                        </div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wide">Jenis Obat</div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-cyan-300 transition-colors group">
                        <div class="flex justify-between items-start mb-2">
                            <div class="p-2 bg-cyan-50 text-cyan-600 rounded-lg group-hover:bg-cyan-600 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <span class="text-2xl font-bold text-slate-800">{{ $stats['total_records'] }}</span>
                        </div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wide">Arsip RM</div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-violet-300 transition-colors group">
                        <div class="flex justify-between items-start mb-2">
                            <div class="p-2 bg-violet-50 text-violet-600 rounded-lg group-hover:bg-violet-600 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            </div>
                            <span class="text-2xl font-bold text-slate-800">{{ $stats['total_lab_logs'] }}</span>
                        </div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wide">Arsip Lab</div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-rose-300 transition-colors group">
                        <div class="flex justify-between items-start mb-2">
                            <div class="p-2 bg-rose-50 text-rose-600 rounded-lg group-hover:bg-rose-600 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <span class="text-2xl font-bold text-slate-800">{{ $stats['total_diseases'] }}</span>
                        </div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wide">Data Penyakit</div>
                    </div>

                    <div class="bg-red-50 p-5 rounded-2xl border border-red-100 shadow-sm hover:shadow-md transition-shadow group">
                        <div class="flex justify-between items-start mb-2">
                            <div class="p-2 bg-white text-red-600 rounded-lg shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <span class="text-2xl font-bold text-red-700">{{ $criticalMedicines->count() }}</span>
                        </div>
                        <div class="text-xs font-bold text-red-600 uppercase tracking-wide">Perlu Restock</div>
                    </div>

                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 lg:col-span-2">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-slate-800">Tren Kunjungan (7 Hari)</h3>
                    </div>
                    <div id="chart-visits"></div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <h3 class="text-lg font-bold text-slate-800 mb-6">Top 5 Diagnosa</h3>
                    <div id="chart-diseases"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <h3 class="font-bold text-slate-800">Pasien Terakhir</h3>
                        <a href="{{ route('clinical.records.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center">
                            Lihat Semua <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                    <table class="w-full text-sm text-left">
                        <tbody class="divide-y divide-slate-100">
                            @forelse($latestRecords as $rec)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-5 py-3">
                                    <div class="font-bold text-slate-800">{{ $rec->patient->name }}</div>
                                    <div class="text-xs text-slate-400 font-mono mt-0.5">{{ $rec->code }}</div>
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <span class="text-[10px] font-bold bg-slate-100 text-slate-500 px-2 py-1 rounded-full">
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

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-5 border-b border-red-50 flex justify-between items-center bg-red-50/30">
                        <div class="flex items-center">
                            <span class="w-2 h-2 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                            <h3 class="font-bold text-red-800">Stok Obat Menipis (≤ 10)</h3>
                        </div>
                        <a href="{{ route('inventory.medicines.index') }}" class="text-xs font-bold text-red-600 hover:text-red-800 hover:underline">Kelola</a>
                    </div>
                    <table class="w-full text-sm text-left">
                        <tbody class="divide-y divide-slate-100">
                            @forelse($criticalMedicines as $med)
                            <tr class="hover:bg-red-50/30 transition-colors">
                                <td class="px-5 py-3">
                                    <div class="font-bold text-slate-800">{{ $med->name }}</div>
                                    <div class="text-xs text-slate-400 font-mono">{{ $med->code }}</div>
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded-lg text-xs font-bold border border-red-200">
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
            
            // 1. Chart Visits
            var optionsVisits = {
                chart: { type: 'area', height: 300, toolbar: { show: false }, fontFamily: 'inherit' },
                series: [{ name: 'Total Pasien', data: @json($chartVisits) }],
                xaxis: { 
                    categories: @json($chartDates),
                    labels: { style: { colors: '#64748b', fontSize: '12px' } },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: { labels: { style: { colors: '#64748b', fontSize: '12px' } } },
                colors: ['#2563eb'],
                stroke: { curve: 'smooth', width: 3 },
                fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] } },
                dataLabels: { enabled: false },
                grid: { borderColor: '#f1f5f9', strokeDashArray: 4 }
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
                    legend: { position: 'bottom', fontSize: '13px', itemMargin: { horizontal: 10, vertical: 5 } },
                    plotOptions: { pie: { donut: { size: '65%', labels: { show: true, total: { show: true, label: 'Total', fontSize: '14px', fontWeight: 600, color: '#64748b' } } } } },
                    dataLabels: { enabled: false }
                };
                new ApexCharts(document.querySelector("#chart-diseases"), optionsDiseases).render();
            } else {
                document.querySelector("#chart-diseases").innerHTML = "<div class='text-center text-slate-400 py-20 italic bg-slate-50 rounded-xl'>Belum ada data diagnosa.</div>";
            }
        });
    </script>
</x-app-layout>