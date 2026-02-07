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
            {{-- INPUT PASIEN (ALPINE JS) --}}
            <div>
                @php
                    $patientOptions = $patients->map(function($p) {
                        $subDeptName = $p->subDepartment->name ?? '';
                        if ($p?->nik != null) {
                            # return [
                            #    'id' => $p->id,
                            #    'label' => $p->name .' - ' . $subDeptName . ' (' . $p->nik . ')' . ' (' . $p->code . ')',
                            #    'code' => $p->code
                            #];
                            return [
                                'id' => $p->id,
                                'label' => $p->name .' - ' . $subDeptName . ' (' . $p->nik . ')',
                                'code' => $p->code
                            ];
                        }else{
                            return [
                                'id' => $p->id,
                                'label' => $p->name .' - (UMUM)'  . ' (' . $p->code . ')',
                                'code' => $p->code
                            ];
                        }
                        
                    });
                @endphp

                {{-- PERBAIKAN: class="w-full relative" digabung jadi satu --}}
                <div class="w-full relative"
                     x-data="{
                        options: {{ $patientOptions }},
                        isOpen: false,
                        search: '',
                        selectedId: '{{ old('patient_id') }}',
                        selectedLabel: '',

                        init() {
                            if (this.selectedId) {
                                const found = this.options.find(o => o.id == this.selectedId);
                                if (found) {
                                    this.selectedLabel = found.label;
                                    this.search = found.label;
                                }
                            }
                            this.$watch('isOpen', (value) => {
                                if (!value && !this.selectedId) {
                                    this.search = '';
                                } else if (!value && this.selectedId) {
                                    this.selectedLabel = this.options.find(o => o.id == this.selectedId)?.label || '';
                                    this.search = this.selectedLabel;
                                }
                            });
                        },
                        get filteredOptions() {
                            if (this.search === '') return this.options;
                            return this.options.filter(option => 
                                option.label.toLowerCase().includes(this.search.toLowerCase())
                            );
                        },
                        selectOption(option) {
                            this.selectedId = option.id;
                            this.selectedLabel = option.label;
                            this.search = option.label;
                            this.isOpen = false;
                        },
                        clearSelection() {
                            this.selectedId = '';
                            this.selectedLabel = '';
                            this.search = '';
                            this.isOpen = true;
                        }
                     }"
                     @click.outside="isOpen = false">

                    <label class="block text-sm font-bold mb-2 text-slate-700 dark:text-slate-300">
                        Pilih Pasien <span class="text-red-500">*</span>
                    </label>

                    <input type="hidden" name="patient_id" :value="selectedId">

                    <div class="relative">
                        <input type="text"
                               x-model="search"
                               @click="isOpen = true"
                               @keydown.escape="isOpen = false"
                               @input="isOpen = true; selectedId = ''" 
                               placeholder="Ketik Nama atau Kode Pasien..."
                               class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all text-sm py-2.5 pl-4 pr-10"
                               autocomplete="off">

                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                            <button type="button" x-show="selectedId || search" @click="clearSelection()" class="text-slate-400 hover:text-red-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                            <button type="button" x-show="!selectedId && !search" @click="isOpen = !isOpen" class="text-slate-400">
                                <svg class="w-4 h-4 transform transition-transform" :class="isOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div x-show="isOpen"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute z-50 mt-1 w-full bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-100 dark:border-slate-600 max-h-60 overflow-auto py-1"
                         style="display: none;">
                        
                        <template x-for="option in filteredOptions" :key="option.id">
                            <div @click="selectOption(option)"
                                 class="px-4 py-2 text-sm cursor-pointer hover:bg-blue-50 dark:hover:bg-slate-700 transition-colors flex justify-between items-center"
                                 :class="selectedId == option.id ? 'bg-blue-50 text-blue-700 dark:bg-slate-700 dark:text-blue-300 font-bold' : 'text-slate-700 dark:text-slate-200'">
                                <span x-text="option.label"></span>
                                <svg x-show="selectedId == option.id" class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </template>

                        <div x-show="filteredOptions.length === 0" class="px-4 py-3 text-sm text-slate-400 italic text-center">
                            Pasien tidak ditemukan.
                        </div>
                    </div>
                </div>
            </div>

            @php
    $doctorList = $doctors->map(function($doc) {
        return [
            'id' => $doc->id,
            'label' => 'dr. ' . $doc->name . ' (' . ($doc->position->name ?? 'Dokter') . ')',
            'search_text' => strtolower('dr. ' . $doc->name . ' ' . ($doc->position->name ?? ''))
        ];
    });

    $nurseList = $nurses->map(function($nur) {
        return [
            'id' => $nur->id,
            'label' => $nur->nama . ' (' . ($nur->position->name ?? 'Perawat') . ')',
            'search_text' => strtolower($nur->nama . ' ' . ($nur->position->name ?? ''))
        ];
    });
@endphp
<div class="space-y-6"
     x-data="{
        // --- DATA SOURCE ---
        doctors: {{ $doctorList }},
        nurses: {{ $nurseList }},

        // --- STATE NILAI TERPILIH ---
        docId: '{{ old('doctor_id') }}',
        nurId: '{{ old('nurse_id') }}',
        docLabel: '',
        nurLabel: '',

        // --- STATE PENCARIAN & DROPDOWN ---
        docSearch: '',
        docOpen: false,
        nurSearch: '',
        nurOpen: false,

        init() {
            // Setup Label Awal jika ada old value (saat edit/error)
            if (this.docId) {
                const d = this.doctors.find(x => x.id == this.docId);
                if (d) { this.docLabel = d.label; this.docSearch = d.label; }
            }
            if (this.nurId) {
                const n = this.nurses.find(x => x.id == this.nurId);
                if (n) { this.nurLabel = n.label; this.nurSearch = n.label; }
            }

            // Watcher: Reset search text jika dropdown ditutup tanpa memilih
            this.$watch('docOpen', (val) => {
                if (!val) this.docSearch = this.docId ? this.docLabel : '';
            });
            this.$watch('nurOpen', (val) => {
                if (!val) this.nurSearch = this.nurId ? this.nurLabel : '';
            });
        },

        // --- LOGIKA FILTERING ---
        get filteredDoctors() {
            if (this.docSearch === '') return this.doctors;
            return this.doctors.filter(i => i.search_text.includes(this.docSearch.toLowerCase()));
        },
        get filteredNurses() {
            if (this.nurSearch === '') return this.nurses;
            return this.nurses.filter(i => i.search_text.includes(this.nurSearch.toLowerCase()));
        },

        // --- ACTIONS ---
        selectDoc(item) {
            this.docId = item.id;
            this.docLabel = item.label;
            this.docSearch = item.label;
            this.docOpen = false;
        },
        clearDoc() {
            this.docId = '';
            this.docLabel = '';
            this.docSearch = '';
            this.docOpen = true;
        },
        selectNur(item) {
            this.nurId = item.id;
            this.nurLabel = item.label;
            this.nurSearch = item.label;
            this.nurOpen = false;
        },
        clearNur() {
            this.nurId = '';
            this.nurLabel = '';
            this.nurSearch = '';
            this.nurOpen = true;
        }
     }">

    {{-- ================= FORM DOKTER ================= --}}
    <div class="relative" @click.outside="docOpen = false">
        <label class="block text-sm font-bold mb-2 text-slate-700 dark:text-slate-300">
            Dokter Pemeriksa <span x-show="!nurId" class="text-red-500">*</span>
        </label>
        
        <input type="hidden" name="doctor_id" :value="docId">

        <div class="relative">
            <input type="text" x-model="docSearch" 
                   @click="docOpen = true" @input="docOpen = true; docId = ''" @keydown.escape="docOpen = false"
                   placeholder="-- Cari Dokter --"
                   class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-sm py-2.5 pl-4 pr-10 focus:ring-blue-500 focus:border-blue-500"
                   :class="{'border-red-500': !docId && !nurId, 'border-slate-200': docId || nurId}"
                   autocomplete="off">
            
            {{-- Tombol Clear / Arrow --}}
            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                <button type="button" x-show="docId || docSearch" @click="clearDoc()" class="text-slate-400 hover:text-red-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <button type="button" x-show="!docId && !docSearch" @click="docOpen = !docOpen" class="text-slate-400">
                    <svg class="w-4 h-4 transition-transform" :class="docOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
            </div>
        </div>

        {{-- Dropdown Body Dokter --}}
        <div x-show="docOpen" style="display: none;" 
             class="absolute z-50 mt-1 w-full bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-100 dark:border-slate-600 max-h-60 overflow-auto py-1">
            <template x-for="item in filteredDoctors" :key="item.id">
                <div @click="selectDoc(item)" class="px-4 py-2 text-sm cursor-pointer hover:bg-blue-50 dark:hover:bg-slate-700 flex justify-between items-center"
                     :class="docId == item.id ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-700 dark:text-slate-200'">
                    <span x-text="item.label"></span>
                    <svg x-show="docId == item.id" class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
            </template>
            <div x-show="filteredDoctors.length === 0" class="px-4 py-3 text-sm text-slate-400 italic text-center">Dokter tidak ditemukan.</div>
        </div>
        
        <p x-show="!docId && !nurId" class="text-xs text-red-500 mt-1">Wajib diisi jika tidak memilih perawat.</p>
    </div>


    {{-- ================= FORM PERAWAT ================= --}}
    <div class="relative" @click.outside="nurOpen = false">
        <label class="block text-sm font-bold mb-2 text-slate-700 dark:text-slate-300">
            Perawat / Asisten <span x-show="!docId" class="text-red-500">*</span>
        </label>
        
        <input type="hidden" name="nurse_id" :value="nurId">

        <div class="relative">
            <input type="text" x-model="nurSearch" 
                   @click="nurOpen = true" @input="nurOpen = true; nurId = ''" @keydown.escape="nurOpen = false"
                   placeholder="-- Cari Perawat --"
                   class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-sm py-2.5 pl-4 pr-10 focus:ring-blue-500 focus:border-blue-500"
                   :class="{'border-red-500': !docId && !nurId, 'border-slate-200': docId || nurId}"
                   autocomplete="off">

            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                <button type="button" x-show="nurId || nurSearch" @click="clearNur()" class="text-slate-400 hover:text-red-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <button type="button" x-show="!nurId && !nurSearch" @click="nurOpen = !nurOpen" class="text-slate-400">
                    <svg class="w-4 h-4 transition-transform" :class="nurOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
            </div>
        </div>

        {{-- Dropdown Body Perawat --}}
        <div x-show="nurOpen" style="display: none;" 
             class="absolute z-50 mt-1 w-full bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-100 dark:border-slate-600 max-h-60 overflow-auto py-1">
            <template x-for="item in filteredNurses" :key="item.id">
                <div @click="selectNur(item)" class="px-4 py-2 text-sm cursor-pointer hover:bg-blue-50 dark:hover:bg-slate-700 flex justify-between items-center"
                     :class="nurId == item.id ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-700 dark:text-slate-200'">
                    <span x-text="item.label"></span>
                    <svg x-show="nurId == item.id" class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
            </template>
            <div x-show="filteredNurses.length === 0" class="px-4 py-3 text-sm text-slate-400 italic text-center">Perawat tidak ditemukan.</div>
        </div>

        <p x-show="!docId && !nurId" class="text-xs text-red-500 mt-1">Wajib diisi jika tidak memilih dokter.</p>
    </div>

    {{-- Indikator Status Global --}}
    <div class="p-3 rounded-lg text-sm flex items-center transition-colors duration-300"
         :class="(docId || nurId) ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-slate-100 text-slate-500 border border-slate-200'">
        <svg x-show="docId || nurId" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <span x-text="(docId || nurId) ? 'Pemeriksa sudah dipilih (Valid).' : 'Mohon pilih Dokter atau Perawat (Wajib).'"></span>
    </div>

</div>
        </div>
        <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-700">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        {{-- 1. Tipe Kunjungan --}}
        <div>
            <label class="block text-sm font-bold mb-2 text-slate-700 dark:text-slate-300">
                Tipe Kunjungan / Kejadian
            </label>
            <div class="relative">
                <select name="visit_type" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5">
                    <option value="sakit" selected>🤒 Sakit (Umum)</option>
                    <option value="kecelakaan_kerja">⚠️ Kecelakaan Kerja</option>
                </select>
                <p class="text-[10px] text-slate-400 mt-1 italic">Pilih "Kecelakaan Kerja" untuk pelaporan K3.</p>
            </div>
        </div>

        {{-- 2. Checklist Status (Ijin & Rujuk) --}}
        <div>
            <label class="block text-sm font-bold mb-3 text-slate-700 dark:text-slate-300">
                Status Tindak Lanjut
            </label>
            
            <div class="flex flex-col gap-3">
                {{-- Checkbox Ijin Kerja --}}
                <label class="inline-flex items-center cursor-pointer group">
                    <div class="relative flex items-center">
                        <input type="checkbox" name="is_sick_leave" value="1" 
                            class="peer h-5 w-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer transition-all checked:bg-indigo-600">
                    </div>
                    <span class="ml-2 text-sm text-slate-600 dark:text-slate-400 group-hover:text-indigo-600 transition-colors font-medium">
                        Terbitkan Surat Ijin Sakit (Sick Leave)
                    </span>
                </label>

                {{-- Checkbox Rujuk RS --}}
                <label class="inline-flex items-center cursor-pointer group">
                    <div class="relative flex items-center">
                        <input type="checkbox" name="is_referred" value="1" 
                            class="peer h-5 w-5 rounded border-slate-300 text-red-600 focus:ring-red-500 cursor-pointer transition-all checked:bg-red-600">
                    </div>
                    <span class="ml-2 text-sm text-slate-600 dark:text-slate-400 group-hover:text-red-600 transition-colors font-medium">
                        Dirujuk ke Rumah Sakit
                    </span>
                </label>
            </div>
        </div>

    </div>
</div>
    </div>

    {{-- VITAL SIGNS --}}
    <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
        <h3 class="text-sm font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-6 flex items-center">
            <span class="w-2 h-2 bg-rose-500 rounded-full mr-3"></span>
            2. Tanda Vital
        </h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase">Tensi (mmHg)</label>
                <input type="text" name="tensi" placeholder="120/80" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 text-sm focus:border-rose-500 focus:ring-rose-500">
            </div>
            <div>
                <label class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase">Suhu (°C)</label>
                <input type="number" step="0.1" name="suhu_tubuh" placeholder="36.5" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 text-sm focus:border-rose-500 focus:ring-rose-500">
            </div>
            <div>
                <label class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase">Berat (Kg)</label>
                <input type="number" step="0.1" name="berat_badan" placeholder="0" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 text-sm focus:border-rose-500 focus:ring-rose-500">
            </div>
            <div>
                <label class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase">Tinggi (cm)</label>
                <input type="number" step="0.1" name="tinggi_badan" placeholder="0" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 text-sm focus:border-rose-500 focus:ring-rose-500">
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
@php
    // 1. Format data obat untuk JavaScript
    $medicineListJS = $medicines->map(function($m) {
        error_log($m);
        return [
            'id' => $m->id,
            'label' => $m->name,
            'stock' => $m->current_stock, // Info stok
            'search_text' => strtolower($m->name . ' ' . $m->code) // Keyword pencarian
        ];
    });
@endphp

                        <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700" 
     x-data="{ 
        rows: [], 
        addRow() { 
            this.rows.push({ id: '', qty: 1, instructions: '' }); 
        },
        removeRow(index) { 
            this.rows.splice(index, 1); 
        }
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

    <div class="overflow-x-visible"> <table class="w-full text-sm">
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
                        
                        <td class="py-3 pr-2 align-top">
                            <div class="relative w-full"
                                 x-data="{
                                    isOpen: false,
                                    search: '',
                                    
                                    // Ambil nama obat berdasarkan ID saat ini
                                    get currentLabel() {
                                        if(!window.medicineOptions) return '';
                                        const found = window.medicineOptions.find(o => o.id == row.id);
                                        return found ? found.label : '';
                                    },

                                    init() {
                                        this.search = this.currentLabel;
                                        // Reset search jika ditutup tanpa memilih
                                        this.$watch('isOpen', (val) => {
                                            if (!val) this.search = this.currentLabel;
                                            else this.search = ''; // Kosongkan saat dibuka agar mudah mengetik
                                        });
                                    },

                                    // Filter Logic (Max 50 items)
                                    get filteredOptions() {
                                        if (this.search === '') return window.medicineOptions.slice(0, 50);
                                        return window.medicineOptions.filter(item => 
                                            item.search_text.includes(this.search.toLowerCase())
                                        ).slice(0, 50);
                                    },

                                    selectOption(item) {
                                        row.id = item.id;
                                        this.search = item.label;
                                        this.isOpen = false;
                                    },
                                    
                                    clearSelection() {
                                        row.id = '';
                                        this.search = '';
                                        this.isOpen = true;
                                    }
                                 }"
                                 @click.outside="isOpen = false">

                                <input type="hidden" :name="'medicines['+index+'][id]'" :value="row.id">

                                <div class="relative">
                                    <input type="text"
                                           x-model="search"
                                           @click="isOpen = true"
                                           @keydown.escape="isOpen = false"
                                           @input="isOpen = true"
                                           placeholder="Cari Obat..."
                                           class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 dark:text-slate-200 p-2.5 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder-slate-400"
                                           autocomplete="off">

                                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 cursor-pointer">
                                        <button type="button" x-show="row.id" @click="clearSelection()" class="text-slate-400 hover:text-red-500 p-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                        <button type="button" x-show="!row.id" @click="isOpen = !isOpen" class="text-slate-400 p-1">
                                            <svg class="w-3 h-3 transform transition-transform" :class="isOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </button>
                                    </div>
                                </div>

                                <div x-show="isOpen"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     class="absolute z-50 mt-1 w-full min-w-[250px] bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-100 dark:border-slate-600 max-h-48 overflow-auto py-1 text-xs">
                                    
                                    <template x-for="item in filteredOptions" :key="item.id">
                                        <div @click="selectOption(item)"
                                             class="px-3 py-2 cursor-pointer hover:bg-indigo-50 dark:hover:bg-slate-700 transition-colors border-b border-slate-50 dark:border-slate-700 last:border-0"
                                             :class="row.id == item.id ? 'bg-indigo-50 text-indigo-700 dark:bg-slate-700 dark:text-indigo-300' : 'text-slate-700 dark:text-slate-200'">
                                            <div class="flex justify-between items-center">
                                                <span class="font-bold truncate mr-2" x-text="item.label"></span>
                                                <span class="text-[10px] bg-slate-100 dark:bg-slate-600 px-1.5 py-0.5 rounded text-slate-500 dark:text-slate-300 whitespace-nowrap">
                                                    Stok: <span x-text="item.stock"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </template>
                                    
                                    <div x-show="filteredOptions.length === 0" class="px-3 py-3 text-slate-400 italic text-center">
                                        Obat tidak ditemukan.
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="py-3 pr-2 align-top">
                            <input type="number" :name="'medicines['+index+'][qty]'" x-model="row.qty" class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 dark:text-slate-200 p-2.5 text-center font-bold focus:ring-indigo-500" min="1">
                        </td>

                        <td class="py-3 pr-2 align-top">
                            <input type="text" :name="'medicines['+index+'][instructions]'" x-model="row.instructions" class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 dark:text-slate-200 p-2.5 focus:ring-indigo-500" placeholder="3 x 1 sesudah makan">
                        </td>

                        <td class="py-3 text-center align-top">
                            <button type="button" @click="removeRow(index)" class="text-slate-300 hover:text-red-500 transition-colors mt-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
    
    <div x-show="rows.length === 0" class="text-center py-10 border-2 border-dashed border-slate-100 dark:border-slate-700 rounded-2xl">
        <p class="text-slate-400 dark:text-slate-500 text-xs italic">Belum ada obat yang diresepkan.</p>
    </div>

    <div class="flex justify-end pt-6 mt-4 border-t border-slate-100 dark:border-slate-700">
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
        window.medicineOptions = @json($medicineListJS);
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