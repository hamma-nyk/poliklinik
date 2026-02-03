<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Input Rekam Medis Baru') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Pencatatan klinis, diagnosa, dan peresepan obat</p>
            </div>
            <a href="{{ route('clinical.records.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Batal & Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('clinical.records.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- SIDEBAR: IDENTITAS & VITAL --}}
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                            <h3 class="text-sm font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-6 flex items-center">
                                <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
                                1. Administrasi
                            </h3>
                            
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-2">Pasien <span class="text-red-500">*</span></label>
                                    <select name="patient_id" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all text-sm" required>
                                        <option value="">Cari Nama / ID Pasien...</option>
                                        @foreach($patients as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->code }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
    <label class="block font-bold mb-1">Pemeriksa (Dokter / Perawat)</label>
    <select name="examiner" class="w-full rounded-lg border-slate-300 select2" required>
        <option value="">-- Pilih Pemeriksa --</option>
        
        <optgroup label="Dokter">
            @foreach($doctors as $doc)
                <option value="Modules\MasterData\App\Models\Doctor|{{ $doc->id }}">
                    dr. {{ $doc->name }}
                </option>
            @endforeach
        </optgroup>

        <optgroup label="Perawat">
            @foreach($nurses as $nurse)
                <option value="Modules\MasterData\App\Models\Nurse|{{ $nurse->id }}">
                    {{ $nurse->nama }} (Perawat)
                </option>
            @endforeach
        </optgroup>
    </select>
</div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                            <h3 class="text-sm font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-6 flex items-center">
                                <span class="w-2 h-2 bg-rose-500 rounded-full mr-3"></span>
                                2. Tanda Vital
                            </h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase">Tensi (mmHg)</label>
                                    <input type="text" name="tensi" placeholder="120/80" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 text-sm">
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase">Suhu (°C)</label>
                                    <input type="number" step="0.1" name="suhu_tubuh" placeholder="36.5" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 text-sm">
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase">Berat (Kg)</label>
                                    <input type="number" step="0.1" name="berat_badan" placeholder="0" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 text-sm">
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase">Tinggi (cm)</label>
                                    <input type="number" step="0.1" name="tinggi_badan" placeholder="0" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 text-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- MAIN CONTENT: ANAMNESA & RESEP --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                            <h3 class="text-sm font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-6 flex items-center">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full mr-3"></span>
                                3. Anamnesa & Pemeriksaan
                            </h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-2">Keluhan Utama (S) <span class="text-red-500">*</span></label>
                                    <textarea name="keluhan_utama" rows="3" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 transition-all" placeholder="Tuliskan keluhan yang dirasakan pasien..." required></textarea>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-500 uppercase mb-2">Riwayat Penyakit Dahulu</label>
                                        <textarea name="riwayat_penyakit" rows="2" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 text-sm"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-red-500 uppercase mb-2 tracking-tighter">Riwayat Alergi (Kritis)</label>
                                        <textarea name="riwayat_alergi" rows="2" class="w-full rounded-xl border-red-200 dark:border-red-900/30 bg-red-50 dark:bg-red-900/10 dark:text-red-200 text-sm placeholder-red-300" placeholder="Sebutkan alergi obat/makanan..."></textarea>
                                    </div>
                                </div>
                                
                                <div class="border-t border-slate-100 dark:border-slate-700 pt-6">
                                    <label class="block text-sm font-bold text-indigo-600 dark:text-indigo-400 mb-3 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Diagnosa Utama (A) - ICD 10
                                    </label>
                                    
                                    <div class="dark:tom-select-dark">
                                        <select id="select-diagnosa" name="diagnosa_input" placeholder="Cari Kode atau Nama Penyakit..." autocomplete="off">
                                            <option value="">Cari Diagnosa...</option>
                                            @foreach($diagnoses as $d)
                                                <option value="{{ $d->id }}">{{ $d->code }} — {{ $d->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-2 italic">
                                        * Jika diagnosa tidak ditemukan, Anda dapat mengetik diagnosa baru dan menekan <span class="font-bold">Enter</span>. Penyakit baru akan tersimpan otomatis.
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-2">Tindakan / Terapi Non-Obat (P)</label>
                                    <textarea name="tindakan" rows="2" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 text-sm" placeholder="Contoh: Edukasi diet rendah garam, Rawat luka..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700" 
                             x-data="{ 
                                rows: [], 
                                addRow() { this.rows.push({ id: '', qty: 1, instructions: '' }) },
                                removeRow(index) { this.rows.splice(index, 1) }
                             }">
                            
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-sm font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest flex items-center">
                                    <span class="w-2 h-2 bg-indigo-500 rounded-full mr-3"></span>
                                    4. Resep Obat
                                </h3>
                                <button type="button" @click="addRow()" class="inline-flex items-center px-4 py-2 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 text-xs font-black rounded-xl border border-indigo-100 dark:border-indigo-800 hover:bg-indigo-600 hover:text-white transition-all">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    TAMBAH BARIS
                                </button>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">
                                        <tr>
                                            <th class="px-2 py-3 text-left w-5/12">Nama Obat</th>
                                            <th class="px-2 py-3 text-center w-2/12">Qty</th>
                                            <th class="px-2 py-3 text-left w-4/12">Aturan Pakai</th>
                                            <th class="px-2 py-3 text-center w-1/12"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50 dark:divide-slate-700">
                                        <template x-for="(row, index) in rows" :key="index">
                                            <tr class="group">
                                                <td class="py-3 pr-2">
                                                    <select :name="'medicines['+index+'][id]'" x-model="row.id" class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 dark:text-slate-200 p-2.5 focus:ring-indigo-500" required>
                                                        <option value="">-- Pilih Obat --</option>
                                                        @foreach($medicines as $med)
                                                            <option value="{{ $med->id }}">{{ $med->name }} (Stok: {{ $med->current_stock }})</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="py-3 pr-2">
                                                    <input type="number" :name="'medicines['+index+'][qty]'" x-model="row.qty" class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 dark:text-slate-200 p-2.5 text-center font-bold" min="1">
                                                </td>
                                                <td class="py-3 pr-2">
                                                    <input type="text" :name="'medicines['+index+'][instructions]'" x-model="row.instructions" class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 dark:text-slate-200 p-2.5" placeholder="Contoh: 3 x 1 tablet">
                                                </td>
                                                <td class="py-3 text-center">
                                                    <button type="button" @click="removeRow(index)" class="text-slate-300 hover:text-red-500 transition-colors">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div x-show="rows.length === 0" class="text-center py-10 border-2 border-dashed border-slate-100 dark:border-slate-700 rounded-2xl">
                                <p class="text-slate-400 dark:text-slate-500 text-xs italic">Tidak ada obat yang diresepkan. Klik tombol tambah untuk memulai.</p>
                            </div>
                        </div>

                        {{-- Footer Action --}}
                        <div class="flex justify-end pt-6">
                            <button type="submit" class="w-full md:w-auto bg-indigo-600 text-white px-10 py-4 rounded-2xl font-black hover:bg-indigo-700 shadow-xl shadow-indigo-500/20 transform hover:-translate-y-1 transition-all uppercase tracking-widest text-sm">
                                Simpan Rekam Medis
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var diagnosaSelect = new TomSelect("#select-diagnosa",{
                create: true,
                persist: false,
                createOnBlur: true,
                maxOptions: 50,
                onOptionAdd: function(value, data) {
                    console.log('Diagnosa baru disiapkan:', value);
                }
            });

            // Prevent Submit on Enter inside TomSelect
            const tsInput = document.querySelector('.ts-control input');
            if(tsInput) {
                tsInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>

    <style>
        /* Dark mode compatibility for TomSelect */
        .dark .ts-control {
            background-color: #334155;
            border-color: #475569;
            color: #f1f5f9;
            border-radius: 0.75rem;
        }
        .dark .ts-dropdown {
            background-color: #1e293b;
            color: #f1f5f9;
            border-color: #475569;
        }
        .dark .ts-dropdown .active {
            background-color: #334155;
            color: #fff;
        }
    </style>
</x-app-layout>