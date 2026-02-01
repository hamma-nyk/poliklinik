<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">{{ __('Pusat Laporan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <a href="{{ route('clinical.reports.visits') }}" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border border-slate-200 group">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="font-bold text-lg text-slate-800">Kunjungan Pasien</h3>
                            <p class="text-sm text-slate-500">Rekap pasien harian/bulanan.</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('clinical.reports.diseases') }}" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border border-slate-200 group">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 text-red-600 rounded-lg group-hover:bg-red-600 group-hover:text-white transition">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="font-bold text-lg text-slate-800">10 Besar Penyakit</h3>
                            <p class="text-sm text-slate-500">Statistik diagnosa terbanyak.</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('clinical.reports.medicines') }}" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border border-slate-200 group">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 text-green-600 rounded-lg group-hover:bg-green-600 group-hover:text-white transition">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="font-bold text-lg text-slate-800">Pemakaian Obat</h3>
                            <p class="text-sm text-slate-500">Laporan keluar masuk obat.</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('clinical.reports.incoming') }}" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border border-slate-200 group">
    <div class="flex items-center">
        <div class="p-3 bg-indigo-100 text-indigo-600 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20"></path></svg>
        </div>
        <div class="ml-4">
            <h3 class="font-bold text-lg text-slate-800">Obat Masuk</h3>
            <p class="text-sm text-slate-500">Laporan pembelian/restock.</p>
        </div>
    </div>

</a>
<a href="{{ route('clinical.reports.mutation') }}" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border border-slate-200 group">
    <div class="flex items-center">
        <div class="p-3 bg-purple-100 text-purple-600 rounded-lg group-hover:bg-purple-600 group-hover:text-white transition">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
        </div>
        <div class="ml-4">
            <h3 class="font-bold text-lg text-slate-800">Mutasi Stok</h3>
            <p class="text-sm text-slate-500">Rekap Masuk & Keluar Obat.</p>
        </div>
    </div>
</a>
<a href="{{ route('clinical.reports.low_stock') }}" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border border-slate-200 group">
    <div class="flex items-center">
        <div class="p-3 bg-amber-100 text-amber-600 rounded-lg group-hover:bg-amber-600 group-hover:text-white transition">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <div class="ml-4">
            <h3 class="font-bold text-lg text-slate-800">Stok Menipis</h3>
            <p class="text-sm text-slate-500">Peringatan stok obat rendah.</p>
        </div>
    </div>
</a>
            </div>
        </div>
    </div>
</x-app-layout>