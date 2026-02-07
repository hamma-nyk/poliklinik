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
                        @php
    // Format data pasien untuk JavaScript
    $patientList = $patients->map(function($p) {
        return [
            'id' => $p->id,
            'label' => $p->name . ' (' . $p->code . ')', // Teks yang tampil
            'search_text' => strtolower($p->name . ' ' . $p->code) // Teks untuk pencarian (lowercase)
        ];
    });
@endphp
                        <div class="w-full relative"
     x-data="{
        options: {{ $patientList }},
        isOpen: false,
        search: '',
        selectedId: '{{ old('patient_id') }}', // Handle old value (validasi error)
        selectedLabel: '',

        init() {
            // Jika ada selectedId (dari old value atau edit mode), set labelnya
            if (this.selectedId) {
                const found = this.options.find(o => o.id == this.selectedId);
                if (found) {
                    this.selectedLabel = found.label;
                    this.search = found.label;
                }
            }

            // Watcher: Reset search jika user menutup dropdown tanpa memilih
            this.$watch('isOpen', (value) => {
                if (!value) {
                    if (this.selectedId) {
                        // Kembalikan ke label terpilih
                        this.selectedLabel = this.options.find(o => o.id == this.selectedId)?.label;
                        this.search = this.selectedLabel;
                    } else {
                        // Kosongkan jika belum ada yg dipilih
                        this.search = '';
                    }
                }
            });
        },

        get filteredOptions() {
            if (this.search === '') return this.options;
            const query = this.search.toLowerCase();
            return this.options.filter(item => item.search_text.includes(query));
        },

        selectOption(item) {
            this.selectedId = item.id;
            this.selectedLabel = item.label;
            this.search = item.label;
            this.isOpen = false;
        },

        clearSelection() {
            this.selectedId = '';
            this.selectedLabel = '';
            this.search = '';
            this.isOpen = true; // Tetap buka dropdown
        }
     }"
     @click.outside="isOpen = false">

    <input type="hidden" name="patient_id" :value="selectedId" required>

    <div class="relative">
        <input type="text"
               x-model="search"
               @click="isOpen = true"
               @keydown.escape="isOpen = false"
               @input="isOpen = true; selectedId = ''" 
               placeholder="-- Cari Nama / ID Pasien --"
               class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-purple-500 focus:ring-purple-500 transition-all text-sm py-2.5 pl-4 pr-10"
               autocomplete="off">

        <div class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
            <button type="button" x-show="selectedId || search" @click="clearSelection()" class="text-slate-400 hover:text-red-500 focus:outline-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <button type="button" x-show="!selectedId && !search" @click="isOpen = !isOpen" class="text-slate-400 focus:outline-none">
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

        <template x-for="item in filteredOptions" :key="item.id">
            <div @click="selectOption(item)"
                 class="px-4 py-2 text-sm cursor-pointer hover:bg-purple-50 dark:hover:bg-slate-700 transition-colors flex justify-between items-center"
                 :class="selectedId == item.id ? 'bg-purple-50 text-purple-700 dark:bg-slate-700 dark:text-purple-300 font-bold' : 'text-slate-700 dark:text-slate-200'">
                
                <span x-text="item.label"></span>
                
                <svg x-show="selectedId == item.id" class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
        </template>

        <div x-show="filteredOptions.length === 0" class="px-4 py-3 text-sm text-slate-400 italic text-center">
            Pasien tidak ditemukan.
        </div>
    </div>
</div>
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