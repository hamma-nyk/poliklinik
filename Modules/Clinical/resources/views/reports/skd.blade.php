<x-app-layout title="Laporan SKD">
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800">Laporan Surat Keterangan Dokter</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
                <form action="{{ route('clinical.reports.skd_export') }}" method="POST" target="_blank">
                    @csrf
                    
                    <div class="mb-6">
                        <label class="block font-bold mb-2">Periode Tanggal</label>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-xs text-slate-500">Dari Tanggal</span>
                                <input type="date" name="start_date" value="{{ date('Y-m-01') }}" class="w-full rounded-xl border-slate-300" required>
                            </div>
                            <div>
                                <span class="text-xs text-slate-500">Sampai Tanggal</span>
                                <input type="date" name="end_date" value="{{ date('Y-m-t') }}" class="w-full rounded-xl border-slate-300" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block font-bold mb-2">Format Laporan</label>
                        <div class="grid grid-cols-3 gap-4">
                            <label class="cursor-pointer border p-4 rounded-xl hover:bg-slate-50 flex flex-col items-center gap-2">
                                <input type="radio" name="format" value="view" checked class="text-indigo-600">
                                <span class="text-sm font-bold">👀 Preview Web</span>
                            </label>
                            <label class="cursor-pointer border p-4 rounded-xl hover:bg-green-50 border-green-100 flex flex-col items-center gap-2">
                                <input type="radio" name="format" value="excel" class="text-green-600">
                                <span class="text-sm font-bold text-green-700">📊 Excel (.xlsx)</span>
                            </label>
                            <label class="cursor-pointer border p-4 rounded-xl hover:bg-red-50 border-red-100 flex flex-col items-center gap-2">
                                <input type="radio" name="format" value="pdf" class="text-red-600">
                                <span class="text-sm font-bold text-red-700">📄 PDF Document</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 shadow-lg">
                        Proses Laporan
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>