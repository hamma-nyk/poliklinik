<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Dashboard Operasional') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div>
                <!-- <h3 class="text-lg font-bold text-slate-700 mb-4 flex items-center">
                    <span class="bg-blue-600 w-2 h-6 rounded-full mr-2"></span>
                    Pantauan Hari Ini
                </h3> -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-500 rounded-2xl p-6 text-white shadow-lg shadow-blue-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-blue-100 font-medium mb-1">Total Aktivitas Hari Ini</p>
                                <h4 class="text-4xl font-bold">{{ $stats['today_activity'] }}</h4>
                            </div>
                            <div class="p-2 bg-white/20 rounded-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                        </div>
                        <p class="text-sm text-blue-100 mt-4">Gabungan Poli & Lab</p>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 font-medium mb-1">Pasien Poli Umum</p>
                            <h4 class="text-3xl font-bold text-slate-800">{{ $stats['today_rm'] }}</h4>
                            <p class="text-xs text-green-600 mt-1 font-bold">Sedang berlangsung</p>
                        </div>
                        <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 font-medium mb-1">Cek Lab (POCT)</p>
                            <h4 class="text-3xl font-bold text-slate-800">{{ $stats['today_lab'] }}</h4>
                            <p class="text-xs text-purple-600 mt-1 font-bold">Sedang berlangsung</p>
                        </div>
                        <div class="p-3 bg-purple-50 text-purple-600 rounded-xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-bold text-slate-700 mb-4 flex items-center">
                    <!-- <span class="bg-slate-600 w-2 h-6 rounded-full mr-2"></span> -->
                    Database Keseluruhan
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    
                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                        <div class="text-xs text-slate-500 font-bold uppercase">Total Pasien</div>
                        <div class="mt-2 flex justify-between items-end">
                            <span class="text-2xl font-bold text-slate-800">{{ $stats['total_patients'] }}</span>
                            <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                        <div class="text-xs text-indigo-500 font-bold uppercase">Total Dokter</div>
                        <div class="mt-2 flex justify-between items-end">
                            <span class="text-2xl font-bold text-slate-800">{{ $stats['total_doctors'] }}</span>
                            <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                        <div class="text-xs text-pink-500 font-bold uppercase">Total Perawat</div>
                        <div class="mt-2 flex justify-between items-end">
                            <span class="text-2xl font-bold text-slate-800">{{ $stats['total_nurses'] }}</span>
                            <svg class="w-5 h-5 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                        <div class="text-xs text-green-500 font-bold uppercase">Jenis Obat</div>
                        <div class="mt-2 flex justify-between items-end">
                            <span class="text-2xl font-bold text-slate-800">{{ $stats['total_medicines'] }}</span>
                            <svg class="w-5 h-5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                        <div class="text-xs text-blue-500 font-bold uppercase">Arsip Rekam Medis</div>
                        <div class="mt-2 flex justify-between items-end">
                            <span class="text-2xl font-bold text-slate-800">{{ $stats['total_records'] }}</span>
                            <span class="text-xs text-slate-400">Total Transaksi</span>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                        <div class="text-xs text-purple-500 font-bold uppercase">Arsip Cek Lab</div>
                        <div class="mt-2 flex justify-between items-end">
                            <span class="text-2xl font-bold text-slate-800">{{ $stats['total_lab_logs'] }}</span>
                            <span class="text-xs text-slate-400">Total Transaksi</span>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                        <div class="text-xs text-red-500 font-bold uppercase">Database Penyakit</div>
                        <div class="mt-2 flex justify-between items-end">
                            <span class="text-2xl font-bold text-slate-800">{{ $stats['total_diseases'] }}</span>
                            <span class="text-xs text-slate-400">ICD-10</span>
                        </div>
                    </div>

                     <div class="bg-red-50 p-4 rounded-xl border border-red-100 shadow-sm">
                        <div class="text-xs text-red-600 font-bold uppercase">Perlu Restock</div>
                        <div class="mt-2 flex justify-between items-end">
                            <span class="text-2xl font-bold text-red-700">{{ $criticalMedicines->count() }}</span>
                            <span class="text-xs text-red-400 font-bold">ITEM OBAT</span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 lg:col-span-2">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-slate-800">Tren Kunjungan (7 Hari)</h3>
                    </div>
                    <div id="chart-visits"></div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Top 5 Diagnosa</h3>
                    <div id="chart-diseases"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-4 border-b bg-slate-50 flex justify-between items-center">
                        <h3 class="font-bold text-slate-700">Pasien Terakhir</h3>
                        <a href="{{ route('clinical.records.index') }}" class="text-xs text-blue-600 hover:underline">Lihat Semua</a>
                    </div>
                    <table class="w-full text-sm text-left">
                        <tbody class="divide-y divide-slate-100">
                            @forelse($latestRecords as $rec)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3">
                                    <div class="font-bold text-slate-800">{{ $rec->patient->name }}</div>
                                    <div class="text-xs text-slate-400">{{ $rec->code }}</div>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <span class="text-xs bg-slate-100 px-2 py-1 rounded text-slate-600">
                                        {{ $rec->created_at->diffForHumans() }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="2" class="p-4 text-center text-slate-400">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-4 border-b bg-red-50 flex justify-between items-center">
                        <h3 class="font-bold text-red-800">Stok Obat Menipis (< 10)</h3>
                        <a href="{{ route('inventory.medicines.index') }}" class="text-xs text-red-600 hover:underline">Kelola</a>
                    </div>
                    <table class="w-full text-sm text-left">
                        <tbody class="divide-y divide-slate-100">
                            @forelse($criticalMedicines as $med)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3">
                                    <div class="font-bold text-slate-800">{{ $med->name }}</div>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-bold">
                                        Sisa: {{ $med->current_stock }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="2" class="p-4 text-center text-green-600 font-bold">Stok aman!</td></tr>
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
                chart: { type: 'area', height: 300, toolbar: { show: false } },
                series: [{ name: 'Total Pasien', data: @json($chartVisits) }],
                xaxis: { categories: @json($chartDates) },
                colors: ['#2563eb'],
                stroke: { curve: 'smooth', width: 2 },
                fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.5, opacityTo: 0.05 } },
                dataLabels: { enabled: false }
            };
            new ApexCharts(document.querySelector("#chart-visits"), optionsVisits).render();

            // 2. Chart Diseases
            var dataDisease = @json($chartDiseaseData);
            if(dataDisease.length > 0) {
                var optionsDiseases = {
                    chart: { type: 'donut', height: 300 },
                    series: dataDisease,
                    labels: @json($chartDiseaseLabels),
                    colors: ['#ef4444', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6'],
                    legend: { position: 'bottom' }
                };
                new ApexCharts(document.querySelector("#chart-diseases"), optionsDiseases).render();
            } else {
                document.querySelector("#chart-diseases").innerHTML = "<div class='text-center text-slate-400 py-10'>Belum ada data.</div>";
            }
        });
    </script>
</x-app-layout>