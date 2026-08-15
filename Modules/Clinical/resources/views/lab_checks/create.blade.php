<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">
                    {{ __('Input Hasil Lab') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Pencatatan Point of Care Testing (POCT)</p>
            </div>
             <div class="hidden md:flex items-center text-sm text-slate-500 mt-2 md:mt-0 dark:text-slate-400">
                <span class="hover:text-slate-900 dark:hover:text-slate-50 cursor-pointer transition-colors"><a href="{{ route('clinical.lab.index') }}">Laboratorium</a></span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-900 dark:text-slate-50">Cek</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 p-6">
                
                <h3 class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-6 flex items-center">
                    <span class="bg-slate-900 dark:bg-slate-50 w-1 h-4 rounded-full mr-3"></span>
                    Form Pemeriksaan Spesimen
                </h3>

                <form action="{{ route('clinical.lab.store') }}" method="POST">
                    @csrf

                    <div class="mb-8">
                        <label class="block text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-2">Pilih Pasien <span class="text-red-500">*</span></label>
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
               class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 pl-4 pr-10 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300"
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
         class="absolute z-50 mt-1 w-full rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 max-h-60 overflow-auto py-1"
         style="display: none;">

        <template x-for="item in filteredOptions" :key="item.id">
            <div @click="selectOption(item)"
                 class="px-4 py-2 text-sm cursor-pointer hover:bg-slate-100 hover:text-slate-900 dark:hover:bg-slate-800 dark:hover:text-slate-50 transition-colors flex justify-between items-center"
                 :class="selectedId == item.id ? 'bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-slate-50 font-bold' : 'text-slate-700 dark:text-slate-200'">
                
                <span x-text="item.label"></span>
                
                <svg x-show="selectedId == item.id" class="w-4 h-4 text-slate-900 dark:text-slate-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
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
                            <label class="block text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Gula Darah (mg/dL)</label>
                            <input type="number" name="gula_darah" placeholder="0" 
                                class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Kolesterol (mg/dL)</label>
                            <input type="number" name="kolesterol" placeholder="0" 
                                class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Asam Urat (mg/dL)</label>
                            <input type="number" step="0.1" name="asam_urat" placeholder="0.0" 
                                class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Tensi Darah (mmHg)</label>
                            <input type="text" name="tensi" placeholder="120/80" 
                                class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">
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
        <label class="block text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-2">
            Dokter Pemeriksa <span x-show="!nurId" class="text-red-500">*</span>
        </label>
        
        <input type="hidden" name="doctor_id" :value="docId">

        <div class="relative">
            <input type="text" x-model="docSearch" 
                   @click="docOpen = true" @input="docOpen = true; docId = ''" @keydown.escape="docOpen = false"
                   placeholder="-- Cari Dokter --"
                   class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 pl-4 pr-10 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300"
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
             class="absolute z-50 mt-1 w-full rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 max-h-60 overflow-auto py-1">
            <template x-for="item in filteredDoctors" :key="item.id">
                <div @click="selectDoc(item)" class="px-4 py-2 text-sm cursor-pointer hover:bg-slate-100 hover:text-slate-900 dark:hover:bg-slate-800 dark:hover:text-slate-50 flex justify-between items-center"
                     :class="docId == item.id ? 'bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-slate-50 font-bold' : 'text-slate-700 dark:text-slate-200'">
                    <span x-text="item.label"></span>
                    <svg x-show="docId == item.id" class="w-4 h-4 text-slate-900 dark:text-slate-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
            </template>
            <div x-show="filteredDoctors.length === 0" class="px-4 py-3 text-sm text-slate-400 italic text-center">Dokter tidak ditemukan.</div>
        </div>
        
        <p x-show="!docId && !nurId" class="text-xs text-red-500 mt-1">Wajib diisi jika tidak memilih perawat.</p>
    </div>


    {{-- ================= FORM PERAWAT ================= --}}
    <div class="relative" @click.outside="nurOpen = false">
        <label class="block text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-2">
            Perawat / Asisten <span x-show="!docId" class="text-red-500">*</span>
        </label>
        
        <input type="hidden" name="nurse_id" :value="nurId">

        <div class="relative">
            <input type="text" x-model="nurSearch" 
                   @click="nurOpen = true" @input="nurOpen = true; nurId = ''" @keydown.escape="nurOpen = false"
                   placeholder="-- Cari Perawat --"
                   class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 pl-4 pr-10 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300"
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
             class="absolute z-50 mt-1 w-full rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 max-h-60 overflow-auto py-1">
            <template x-for="item in filteredNurses" :key="item.id">
                <div @click="selectNur(item)" class="px-4 py-2 text-sm cursor-pointer hover:bg-slate-100 hover:text-slate-900 dark:hover:bg-slate-800 dark:hover:text-slate-50 flex justify-between items-center"
                     :class="nurId == item.id ? 'bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-slate-50 font-bold' : 'text-slate-700 dark:text-slate-200'">
                    <span x-text="item.label"></span>
                    <svg x-show="nurId == item.id" class="w-4 h-4 text-slate-900 dark:text-slate-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
            </template>
            <div x-show="filteredNurses.length === 0" class="px-4 py-3 text-sm text-slate-400 italic text-center">Perawat tidak ditemukan.</div>
        </div>

        <p x-show="!docId && !nurId" class="text-xs text-red-500 mt-1">Wajib diisi jika tidak memilih dokter.</p>
    </div>

    @php
    $medicineList = $medicines->map(function($m) {
        return [
            'id' => $m->id,
            'label' => $m->name . ' (' . $m->unit . ')',
            'stock' => $m->current_stock,
            'search_text' => strtolower($m->name . ' ' . $m->code)
        ];
    });
@endphp

{{-- SECTION PENGGUNAAN BHP / ALAT LAB --}}
<div class="mb-10 rounded-md border border-slate-200 bg-slate-50 dark:bg-slate-900 dark:border-slate-800 p-6"
     x-data="{
        allMedicines: {{ $medicineList }},
        items: [],
        
        addItem() {
            this.items.push({
                medicine_id: '',
                medicine_label: '',
                quantity: 1,
                search: '',
                isOpen: false
            });
        },
        
        removeItem(index) {
            this.items.splice(index, 1);
        },

        getFiltered(search) {
            if (search === '') return this.allMedicines;
            return this.allMedicines.filter(m => m.search_text.includes(search.toLowerCase()));
        }
     }" x-init="addItem()"> {{-- Otomatis tambah 1 baris saat load --}}

    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 flex items-center">
            <span class="bg-slate-900 dark:bg-slate-50 w-1 h-4 rounded-full mr-3"></span>
            Penggunaan BHP / Jarum Spuit
        </h3>
        <button type="button" @click="addItem()" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 border border-slate-200 bg-white shadow-sm hover:bg-slate-100 hover:text-slate-900 h-9 px-4 py-2 dark:border-slate-800 dark:bg-slate-950 dark:hover:bg-slate-800 dark:hover:text-slate-50">
            + Tambah Alat
        </button>
    </div>

    <div class="space-y-3">
        <template x-for="(item, index) in items" :key="index">
            <div class="flex gap-3 items-start animate-fade-in">
                
                {{-- Searchable Select --}}
                <div class="flex-1 relative" @click.outside="item.isOpen = false">
                    <input type="hidden" :name="'medicines['+index+'][medicine_id]'" x-model="item.medicine_id">
                    
                    <div class="relative">
                        <input type="text" 
                               x-model="item.search"
                               @click="item.isOpen = true"
                               @input="item.isOpen = true; item.medicine_id = ''"
                               placeholder="Cari jarum, spuit, dll..."
                               class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 pl-4 pr-10 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">
                        
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </div>

                    {{-- Dropdown Hasil Cari --}}
                    <div x-show="item.isOpen" 
                         class="absolute z-[60] mt-1 w-full rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 max-h-48 overflow-auto py-1 text-sm">
                        <template x-for="med in getFiltered(item.search)" :key="med.id">
                            <div @click="
                                    item.medicine_id = med.id;
                                    item.medicine_label = med.label;
                                    item.search = med.label;
                                    item.isOpen = false;
                                 "
                                 class="px-4 py-2 hover:bg-slate-100 hover:text-slate-900 dark:hover:bg-slate-800 dark:hover:text-slate-50 cursor-pointer flex justify-between items-center">
                                <div>
                                    <div class="font-bold text-slate-700 dark:text-slate-200" x-text="med.label"></div>
                                    <div class="text-[10px] text-slate-400">Tersedia: <span x-text="med.stock"></span></div>
                                </div>
                                <svg x-show="item.medicine_id == med.id" class="w-4 h-4 text-slate-900 dark:text-slate-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </template>
                        <div x-show="getFiltered(item.search).length === 0" class="px-4 py-2 text-xs text-slate-400 italic">Alat tidak ditemukan.</div>
                    </div>
                </div>

                {{-- Input Quantity --}}
                <div class="w-24">
                    <input type="number" 
                           :name="'medicines['+index+'][quantity]'" 
                           x-model="item.quantity" 
                           min="1"
                           class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300 text-center font-bold text-slate-700 dark:text-slate-200">
                </div>

                {{-- Tombol Hapus --}}
                <button type="button" 
                        @click="removeItem(index)" 
                        x-show="items.length > 1"
                        class="mt-2 text-slate-400 hover:text-red-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
        </template>
    </div>
    
    <div x-show="items.length === 0" class="text-center py-4 text-xs text-slate-400 italic">
        Klik + Tambah Alat jika pasien menggunakan jarum/BHP lainnya.
    </div>
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
                        <label class="block text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-2">Interpretasi / Catatan (Opsional)</label>
                        <textarea name="notes" class="flex min-h-[80px] w-full rounded-md border border-slate-200 bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300" rows="3" placeholder="Tambahkan catatan jika hasil lab memerlukan perhatian khusus..."></textarea>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('clinical.lab.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 border border-slate-200 bg-white shadow-sm hover:bg-slate-100 hover:text-slate-900 h-9 px-4 py-2 dark:border-slate-800 dark:bg-slate-950 dark:hover:bg-slate-800 dark:hover:text-slate-50 w-full sm:w-auto">
                            BATAL
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 bg-slate-900 text-slate-50 shadow hover:bg-slate-900/90 h-9 px-4 py-2 dark:bg-slate-50 dark:text-slate-900 dark:hover:bg-slate-50/90 w-full sm:w-auto">
                            Simpan & Cetak Hasil
                        </button>
                    </div>
                </form>

            </div>

            <div class="mt-6 p-6 rounded-md border border-slate-200 bg-slate-50 dark:bg-slate-900 dark:border-slate-800 flex items-start gap-4">
                <div class="p-2 bg-slate-100 dark:bg-slate-800 rounded-lg text-slate-600 dark:text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-1">Referensi Batas Normal (Dewasa)</h4>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed font-medium italic">
                        Gula Darah: < 200 mg/dL (Sewaktu) | Kolesterol: < 200 mg/dL | Asam Urat: L(3.4-7.0), P(2.4-6.0) mg/dL.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>