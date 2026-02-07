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

                <form action="{{ route('dashboard') }}" method="GET" class="mb-6 flex items-center gap-2 bg-white dark:bg-slate-800 p-1.5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                {{-- Dropdown Bulan --}}
                <select name="month" onchange="this.form.submit()" class="border-none bg-transparent text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-0 cursor-pointer py-1 pl-3 pr-8">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>

                <span class="text-slate-300 dark:text-slate-600">|</span>

                {{-- Dropdown Tahun --}}
                <select name="year" onchange="this.form.submit()" class="border-none bg-transparent text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-0 cursor-pointer py-1 pl-3 pr-8">
                    @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </form>
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

            {{-- ZONA 1: GRAFIK UTAMA (Trend & Diagnosa) --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Chart Trend Harian --}}
                <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 lg:col-span-2">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="font-bold text-lg text-slate-800 dark:text-slate-100">Tren Kunjungan Harian</h3>
                            <p class="text-xs text-slate-500">Jumlah pasien per hari</p>
                        </div>
                        <span class="bg-indigo-50 text-indigo-600 text-xs font-bold px-2.5 py-1 rounded-lg border border-indigo-100">
                            {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
                        </span>
                    </div>
                    <div id="chart-trend-daily" class="h-64"></div>
                </div>

                {{-- Top 5 Diagnosa --}}
                <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-slate-100 mb-2">Top 5 Diagnosa</h3>
                    <p class="text-xs text-slate-500 mb-6">Penyakit terbanyak bulan ini</p>
                    <div id="chart-diseases" class="flex-grow flex items-center justify-center"></div>
                </div>
            </div>

            {{-- ZONA 2: STATISTIK K3 (Donut & Summary) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Donut Chart Proporsi --}}
                <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-slate-100 mb-2">Proporsi Kunjungan</h3>
                    <p class="text-xs text-slate-500 mb-4">Sakit Umum vs Kecelakaan Kerja</p>
                    <div id="chart-visit-types" class="flex justify-center"></div>
                </div>
                
                {{-- Ringkasan Angka K3 --}}
                <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 lg:col-span-2 flex flex-col justify-center">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-slate-100 mb-6">Ringkasan K3</h3>
                    <div class="grid grid-cols-2 gap-6">
                        {{-- Card Sakit --}}
                        <div class="relative p-6 bg-emerald-50 dark:bg-emerald-900/10 rounded-2xl border border-emerald-100 dark:border-emerald-800 overflow-hidden group hover:border-emerald-300 transition-colors]">
                            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                                <svg class="w-16 h-16 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/></svg>
                            </div>
                            <div class="relative z-10">
                                <div class="text-sm font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-1">Sakit (Umum)</div>
                                <div class="text-4xl font-black text-slate-800 dark:text-slate-100">{{ $sakitCount }}</div>
                                <div class="text-xs text-slate-500 mt-2 font-medium">Kasus bulan ini</div>
                            </div>
                        </div>
                        
                        {{-- Card Kecelakaan --}}
                        <div class="relative p-6 bg-rose-50 dark:bg-rose-900/10 rounded-2xl border border-rose-100 dark:border-rose-800 overflow-hidden group hover:border-rose-300 transition-colors">
                            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                                <svg class="w-16 h-16 text-rose-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                            </div>
                            <div class="relative z-10">
                                <div class="text-sm font-bold text-rose-600 dark:text-rose-400 uppercase tracking-wider mb-1">Kecelakaan Kerja</div>
                                <div class="text-4xl font-black text-slate-800 dark:text-slate-100">{{ $kecelakaanCount }}</div>
                                <div class="text-xs text-slate-500 mt-2 font-medium">Kasus bulan ini</div>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 dark:bg-blue-900/10 border-l-4 border-blue-500 p-4 rounded-r-xl flex items-start gap-3 col-span-2">
                            <svg class="w-6 h-6 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-bold text-blue-800 dark:text-blue-300">Safety First!</p>
                                <p class="text-xs text-blue-600 dark:text-blue-400 mt-1 italic">
                                    "Kecelakaan kerja dapat dihindari. Selalu gunakan APD dan patuhi prosedur kerja. Keluarga Anda menunggu di rumah."
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ZONA 3: OPERASIONAL (Tabel Pasien & Stok Obat) --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                {{-- Tabel Pasien Terakhir --}}
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col">
                    <div class="p-5 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800">
                        <div>
                            <h3 class="font-bold text-slate-800 dark:text-slate-100">Pasien Terakhir</h3>
                            <p class="text-xs text-slate-500">5 kunjungan terbaru hari ini</p>
                        </div>
                        <a href="{{ route('clinical.records.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 bg-indigo-50 px-3 py-1.5 rounded-lg border border-indigo-100 transition-colors">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="overflow-x-auto flex-grow">
                        <table class="w-full text-sm text-left">
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                                @forelse($latestRecords as $rec)
                                <tr class="group hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-600 flex items-center justify-center text-xs font-bold text-slate-500 dark:text-slate-300 mr-3">
                                                {{ substr($rec->patient->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 transition-colors">{{ $rec->patient->name }}</div>
                                                <div class="text-xs text-slate-400 font-mono">{{ $rec->code }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <span class="text-[10px] font-bold bg-slate-100 text-slate-500 px-2 py-1 rounded-md border border-slate-200">
                                            {{ $rec->created_at->format('H:i') }} WIB
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="2" class="p-8 text-center text-slate-400 italic">Belum ada data kunjungan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Tabel Stok Obat Kritis --}}
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col">
                    <div class="p-5 border-b border-red-100 dark:border-red-900/30 flex justify-between items-center bg-red-50/30 dark:bg-red-900/10">
                        <div class="flex items-center gap-2">
                            <span class="relative flex h-3 w-3">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                            </span>
                            <div>
                                <h3 class="font-bold text-red-800 dark:text-red-400">Stok Obat Menipis</h3>
                                <p class="text-xs text-red-600/70 dark:text-red-400/70">Perlu re-stock segera (≤ 10)</p>
                            </div>
                        </div>
                        <a href="{{ route('inventory.medicines.index') }}" class="text-xs font-bold text-red-700 hover:text-red-900 bg-red-100/50 px-3 py-1.5 rounded-lg border border-red-200 transition-colors">
                            Kelola Stok
                        </a>
                    </div>
                    <div class="overflow-x-auto flex-grow">
                        <table class="w-full text-sm text-left">
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                                @forelse($criticalMedicines as $med)
                                <tr class="hover:bg-red-50/30 dark:hover:bg-red-900/20 transition-colors">
                                    <td class="px-5 py-4">
                                        <div class="font-bold text-slate-800 dark:text-slate-200">{{ $med->name }}</div>
                                        <div class="text-xs text-slate-400 font-mono">{{ $med->code }}</div>
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <span class="bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400 px-2.5 py-1 rounded-lg text-xs font-bold border border-red-200 dark:border-red-800 shadow-sm">
                                            Sisa: {{ $med->current_stock }} {{ $med->unit }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="p-8 text-center flex flex-col items-center justify-center">
                                        <svg class="w-10 h-10 text-emerald-400 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="text-emerald-600 font-bold text-sm">Stok aman! Tidak ada yang kritis.</span>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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

            
            // 2. Chart Diseases
            var dataDisease = @json($diagData);
            if(dataDisease.length > 0) {
                var optionsDiseases = {
                    chart: { type: 'donut', height: 320, fontFamily: 'inherit' },
                    series: dataDisease,
                    labels: @json($diagLabels),
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
        document.addEventListener("DOMContentLoaded", function() {
            
            // --- 1. CHART DONAT (Sakit vs Kecelakaan) ---
            var optionsDonut = {
                series: [{{ $sakitCount }}, {{ $kecelakaanCount }}], // Data dari Controller
                labels: ['Sakit', 'Kecelakaan Kerja'],
                chart: { type: 'donut', height: 250 },
                colors: ['#10b981', '#f43f5e'],
                dataLabels: { enabled: false },
                legend: { position: 'bottom' },
                plotOptions: {
                    pie: { donut: { size: '65%' } }
                }
            };
            new ApexCharts(document.querySelector("#chart-visit-types"), optionsDonut).render();


            // --- 2. CHART TREND HARIAN (Line Chart) ---
            var optionsTrend = {
                series: [{
                    name: "Jumlah Pasien",
                    data: @json($trendData) // Array Data [0, 2, 5, 1, ...]
                }],
                chart: {
                    height: 300,
                    type: 'area',
                    toolbar: { show: false },
                    fontFamily: 'Inter, sans-serif',
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2 },
                xaxis: {
                    categories: @json($trendLabels), // Array Tanggal [1, 2, 3, ... 30]
                    title: { text: 'Tanggal' }
                },
                yaxis: { title: { text: 'Pasien' } },
                colors: ['#6366f1'], // Indigo
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.2,
                    }
                }
            };
            new ApexCharts(document.querySelector("#chart-trend-daily"), optionsTrend).render();

        });
    </script>
</x-app-layout>