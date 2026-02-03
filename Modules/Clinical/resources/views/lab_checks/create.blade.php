<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Input Hasil Lab') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Pencatatan Point of Care Testing (POCT)</p>
            </div>
            <a href="{{ route('clinical.lab.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                
                <h3 class="text-sm font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-8 flex items-center">
                    <span class="w-2 h-2 bg-purple-500 rounded-full mr-3"></span>
                    Form Pemeriksaan Spesimen
                </h3>

                <form action="{{ route('clinical.lab.store') }}" method="POST">
                    @csrf

                    <div class="mb-8">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-2">Pilih Pasien <span class="text-red-500">*</span></label>
                        <select name="patient_id" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-purple-500 focus:ring-purple-500 transition-all text-sm py-2.5" required>
                            <option value="">-- Cari Nama / ID Pasien --</option>
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase">Gula Darah (mg/dL)</label>
                            <input type="number" name="gula_darah" placeholder="0" 
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:ring-yellow-500 focus:border-yellow-500 transition-all font-bold">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase">Kolesterol (mg/dL)</label>
                            <input type="number" name="kolesterol" placeholder="0" 
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:ring-blue-500 focus:border-blue-500 transition-all font-bold">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase">Asam Urat (mg/dL)</label>
                            <input type="number" step="0.1" name="asam_urat" placeholder="0.0" 
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:ring-emerald-500 focus:border-emerald-500 transition-all font-bold">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase">Tensi Darah (mmHg)</label>
                            <input type="text" name="tensi" placeholder="120/80" 
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-purple-500 focus:ring-purple-500 transition-all font-bold">
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-2">Petugas Pemeriksa <span class="text-red-500">*</span></label>
                        <select name="examiner" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-purple-500 focus:ring-purple-500 transition-all text-sm py-2.5" required>
                            <option value="">-- Pilih Dokter / Perawat --</option>
                            <optgroup label="Dokter" class="font-bold text-indigo-600">
                                @foreach($doctors as $doc)
                                    <option value="Modules\MasterData\App\Models\Doctor|{{ $doc->id }}">dr. {{ $doc->name }}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Perawat" class="font-bold text-emerald-600">
                                @foreach($nurses as $nurse)
                                    <option value="Modules\MasterData\App\Models\Nurse|{{ $nurse->id }}">{{ $nurse->nama }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>

                    <div class="mb-10">
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase mb-2">Interpretasi / Catatan (Opsional)</label>
                        <textarea name="notes" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-purple-500 focus:ring-purple-500 transition-all text-sm" rows="3" placeholder="Tambahkan catatan jika hasil lab memerlukan perhatian khusus..."></textarea>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end items-center gap-4">
                        <a href="{{ route('clinical.lab.index') }}" class="text-sm font-bold text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                            Batalkan
                        </a>
                        <button type="submit" class="w-full sm:w-auto bg-slate-900 dark:bg-purple-600 text-white px-10 py-3.5 rounded-2xl font-black hover:bg-slate-800 dark:hover:bg-purple-500 shadow-xl shadow-slate-200 dark:shadow-none transition-all transform hover:-translate-y-1 uppercase tracking-widest text-xs">
                            Simpan & Cetak Hasil
                        </button>
                    </div>
                </form>

            </div>

            <div class="mt-6 p-6 bg-purple-50 dark:bg-purple-900/10 border border-purple-100 dark:border-purple-800/30 rounded-2xl flex items-start gap-4">
                <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg text-purple-600 dark:text-purple-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="text-xs font-black text-purple-800 dark:text-purple-300 uppercase tracking-tighter mb-1">Referensi Batas Normal (Dewasa)</h4>
                    <p class="text-[11px] text-purple-700 dark:text-purple-400/80 leading-relaxed font-medium italic">
                        Gula Darah: < 200 mg/dL (Sewaktu) | Kolesterol: < 200 mg/dL | Asam Urat: L(3.4-7.0), P(2.4-6.0) mg/dL.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>