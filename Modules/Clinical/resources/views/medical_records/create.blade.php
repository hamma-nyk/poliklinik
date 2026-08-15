<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Input Rekam Medis Baru') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Pencatatan klinis, diagnosa, dan peresepan obat</p>
            </div>
            <a href="{{ route('clinical.records.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 border border-slate-200 bg-white shadow-sm hover:bg-slate-100 hover:text-slate-900 h-9 px-4 py-2 dark:border-slate-800 dark:bg-slate-950 dark:hover:bg-slate-800 dark:hover:text-slate-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Batal & Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('clinical.records.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- SIDEBAR: IDENTITAS & VITAL --}}
<div class="lg:col-span-1 space-y-6">
    <div class="rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 p-6">
        <h3 class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-6 flex items-center">
            <span class="bg-slate-900 dark:bg-slate-50 w-1 h-4 rounded-full mr-3"></span>
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

                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-2 block text-slate-700 dark:text-slate-300">
                        Pilih Pasien <span class="text-destructive">*</span>
                    </label>

                    <input type="hidden" name="patient_id" :value="selectedId">

                    <div class="relative">
                        <input type="text"
                               x-model="search"
                               @click="isOpen = true"
                               @keydown.escape="isOpen = false"
                               @input="isOpen = true; selectedId = ''" 
                               placeholder="Ketik Nama atau Kode Pasien..."
                               class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300 pr-10 cursor-pointer"
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
                         class="absolute w-full mt-1 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-md shadow-md max-h-60 overflow-y-auto z-50 py-1"
                         style="display: none;">
                        
                        <template x-for="option in filteredOptions" :key="option.id">
                            <div @click="selectOption(option)"
                                 class="cursor-pointer relative flex w-full select-none items-center rounded-sm py-1.5 pl-2 pr-8 text-sm outline-none hover:bg-slate-100 hover:text-slate-900 dark:hover:bg-slate-800 dark:hover:text-slate-50 justify-between"
                                 :class="selectedId == option.id ? 'bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-slate-50' : 'text-slate-700 dark:text-slate-200'">
                                <span class="font-medium" x-text="option.label"></span>
                                <svg x-show="selectedId == option.id" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
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
        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-2 block text-slate-700 dark:text-slate-300">
            Dokter Pemeriksa <span x-show="!nurId" class="text-destructive">*</span>
        </label>
        
        <input type="hidden" name="doctor_id" :value="docId">

        <div class="relative">
            <input type="text" x-model="docSearch" 
                   @click="docOpen = true" @input="docOpen = true; docId = ''" @keydown.escape="docOpen = false"
                   placeholder="-- Cari Dokter --"
                   class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300 pr-10 cursor-pointer"
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
             class="absolute w-full mt-1 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-md shadow-md max-h-60 overflow-y-auto z-50 py-1">
            <template x-for="item in filteredDoctors" :key="item.id">
                <div @click="selectDoc(item)" class="cursor-pointer relative flex w-full select-none items-center rounded-sm py-1.5 pl-2 pr-8 text-sm outline-none hover:bg-slate-100 hover:text-slate-900 dark:hover:bg-slate-800 dark:hover:text-slate-50 justify-between"
                     :class="docId == item.id ? 'bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-slate-50' : 'text-slate-700 dark:text-slate-200'">
                    <span class="font-medium" x-text="item.label"></span>
                    <svg x-show="docId == item.id" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
            </template>
            <div x-show="filteredDoctors.length === 0" class="px-4 py-3 text-sm text-slate-400 italic text-center">Dokter tidak ditemukan.</div>
        </div>
        
        <p x-show="!docId && !nurId" class="text-xs text-red-500 mt-1">Wajib diisi jika tidak memilih perawat.</p>
    </div>


    {{-- ================= FORM PERAWAT ================= --}}
    <div class="relative" @click.outside="nurOpen = false">
        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-2 block text-slate-700 dark:text-slate-300">
            Perawat / Asisten <span x-show="!docId" class="text-destructive">*</span>
        </label>
        
        <input type="hidden" name="nurse_id" :value="nurId">

        <div class="relative">
            <input type="text" x-model="nurSearch" 
                   @click="nurOpen = true" @input="nurOpen = true; nurId = ''" @keydown.escape="nurOpen = false"
                   placeholder="-- Cari Perawat --"
                   class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300 pr-10 cursor-pointer"
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
             class="absolute w-full mt-1 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-md shadow-md max-h-60 overflow-y-auto z-50 py-1">
            <template x-for="item in filteredNurses" :key="item.id">
                <div @click="selectNur(item)" class="cursor-pointer relative flex w-full select-none items-center rounded-sm py-1.5 pl-2 pr-8 text-sm outline-none hover:bg-slate-100 hover:text-slate-900 dark:hover:bg-slate-800 dark:hover:text-slate-50 justify-between"
                     :class="nurId == item.id ? 'bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-slate-50' : 'text-slate-700 dark:text-slate-200'">
                    <span class="font-medium" x-text="item.label"></span>
                    <svg x-show="nurId == item.id" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
            </template>
            <div x-show="filteredNurses.length === 0" class="px-4 py-3 text-sm text-slate-400 italic text-center">Perawat tidak ditemukan.</div>
        </div>

        <p x-show="!docId && !nurId" class="text-xs text-red-500 mt-1">Wajib diisi jika tidak memilih dokter.</p>
    </div>

    {{-- Indikator Status Global --}}
    <div class="p-3 rounded-md text-sm flex items-center transition-colors duration-300"
         :class="(docId || nurId) ? 'bg-emerald-50 text-emerald-900 border border-emerald-200 dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200' : 'bg-slate-100 text-slate-500 border border-slate-200'">
        <svg x-show="docId || nurId" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <span x-text="(docId || nurId) ? 'Pemeriksa sudah dipilih (Valid).' : 'Mohon pilih Dokter atau Perawat (Wajib).'"></span>
    </div>

</div>
        </div>
        <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-800">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        {{-- 1. Tipe Kunjungan --}}
        <div>
            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-2 block text-slate-700 dark:text-slate-300">
                Tipe Kunjungan / Kejadian
            </label>
            <div class="relative">
                <select name="visit_type" class="flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:ring-offset-slate-950 dark:placeholder:text-slate-400 dark:focus:ring-slate-300">
                    <option value="sakit" selected>Sakit (Umum)</option>
                    <option value="kecelakaan_kerja">Kecelakaan Kerja</option>
                </select>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 italic">Pilih "Kecelakaan Kerja" untuk pelaporan K3.</p>
            </div>
        </div>

        {{-- 2. Checklist Status (Ijin & Rujuk) --}}
        <div>
            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-3 block text-slate-700 dark:text-slate-300">
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
    <div class="rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 p-6">
        <h3 class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-6 flex items-center">
            <span class="bg-slate-900 dark:bg-slate-50 w-1 h-4 rounded-full mr-3"></span>
            2. Tanda Vital
        </h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-2 block">Tensi (mmHg)</label>
                <input type="text" name="tensi" placeholder="120/80" class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">
            </div>
            <div>
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-2 block">Suhu (°C)</label>
                <input type="number" step="0.1" name="suhu_tubuh" placeholder="36.5" class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">
            </div>
            <div>
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-2 block">Berat (Kg)</label>
                <input type="number" step="0.1" name="berat_badan" placeholder="0" class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">
            </div>
            <div>
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-2 block">Tinggi (cm)</label>
                <input type="number" step="0.1" name="tinggi_badan" placeholder="0" class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">
            </div>
        </div>
    </div>
</div>

                               
                    {{-- MAIN CONTENT: ANAMNESA & RESEP --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 p-6">
                            <h3 class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-6 flex items-center">
                                <span class="bg-slate-900 dark:bg-slate-50 w-1 h-4 rounded-full mr-3"></span>
                                3. Anamnesa & Pemeriksaan
                            </h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-2 block text-slate-700 dark:text-slate-300">Keluhan Utama (S) <span class="text-destructive">*</span></label>
                                    <textarea name="keluhan_utama" rows="3" class="flex w-full rounded-md border border-slate-200 bg-transparent px-3 py-2 text-sm shadow-sm transition-colors placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300" placeholder="Tuliskan keluhan yang dirasakan pasien..." required></textarea>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-2 block">Riwayat Penyakit Dahulu</label>
                                        <textarea name="riwayat_penyakit" rows="2" class="flex w-full rounded-md border border-slate-200 bg-transparent px-3 py-2 text-sm shadow-sm transition-colors placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300"></textarea>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-2 block text-red-500">Riwayat Alergi (Kritis)</label>
                                        <textarea name="riwayat_alergi" rows="2" class="flex w-full rounded-md border border-red-200 bg-red-50 px-3 py-2 text-sm shadow-sm transition-colors placeholder:text-red-300 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-red-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-red-800 dark:bg-red-950/50 dark:placeholder:text-red-400 dark:focus-visible:ring-red-300 text-red-900 dark:text-red-200" placeholder="Sebutkan alergi obat/makanan..."></textarea>
                                    </div>
                                </div>
                                
                                <div class="border-t border-slate-200 dark:border-slate-800 pt-6">
                                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-3 block flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Diagnosa Utama (A) - ICD 10
                                    </label>
                                    @php
    // 1. Format Data Diagnosa (Sama seperti Pasien)
    // Pastikan $diagnoses diambil dari Controller: Diagnosis::orderBy('name')->get();
    $diagnosaOptions = $diagnoses->map(function($d) {
        return [
            'id'    => $d->id,
            // Label gabungan Kode + Nama agar mudah dibaca
            'label' => '[' . $d->code . '] ' . $d->name, 
            'code'  => $d->code,
            'name'  => $d->name
        ];
    })->values(); // Reset keys jadi array murni
@endphp

{{-- 2. KOMPONEN DIAGNOSA (Style mirip Pasien) --}}
<div class="w-full relative"
     x-data="{
        options: {{ Js::from($diagnosaOptions) }},
        isOpen: false,
        search: '',
        selectedId: '{{ old('diagnosa_input') }}', // ID Diagnosa (jika ada error)
        selectedLabel: '',
        isNewInput: false, // Flag untuk input manual (teks baru)

        init() {
            // A. Cek Old Value (Apakah ID atau Text Baru?)
            if (this.selectedId) {
                // Cek apakah angka (ID)?
                if (!isNaN(this.selectedId)) {
                    const found = this.options.find(o => o.id == this.selectedId);
                    if (found) {
                        this.selectedLabel = found.label;
                        this.search = found.label;
                    }
                } else {
                    // Jika teks (Diagnosa Baru), anggap sebagai search text
                    this.search = this.selectedId;
                    this.isNewInput = true;
                }
            }

            // B. Watcher: Reset search saat dropdown ditutup
            this.$watch('isOpen', (value) => {
                if (!value) {
                    // Jika tutup dropdown, kembalikan teks ke item yang dipilih
                    if (this.selectedId && !this.isNewInput) {
                        const found = this.options.find(o => o.id == this.selectedId);
                        this.search = found ? found.label : '';
                    } else if (this.isNewInput) {
                        // Jika input baru, biarkan teksnya (jangan di-reset)
                        this.search = this.selectedId; 
                    } else {
                        // Jika tidak ada pilihan, kosongkan
                        this.search = '';
                    }
                }
            });
        },

        get filteredOptions() {
            if (this.search === '') return this.options.slice(0, 50); // Limit 50
            const lower = this.search.toLowerCase();
            return this.options.filter(option => 
                option.label.toLowerCase().includes(lower)
            ).slice(0, 50);
        },

        // Pilih dari List
        selectOption(option) {
            this.selectedId = option.id;
            this.selectedLabel = option.label;
            this.search = option.label;
            this.isNewInput = false;
            this.isOpen = false;
        },

        // Tambah Baru (Enter)
        selectNew() {
            if (this.search.length > 0) {
                this.selectedId = this.search; // Kirim teks sebagai value
                this.selectedLabel = this.search;
                this.isNewInput = true;
                this.isOpen = false;
            }
        },

        // Logic Enter Utama
        handleEnter() {
            const list = this.filteredOptions;
            // Jika dropdown terbuka dan ada list, pilih yg pertama (opsional)
            // Atau jika list kosong tapi ada teks, anggap baru
            if (list.length === 0 && this.search.length > 0) {
                this.selectNew();
            }
        },

        clearSelection() {
            this.selectedId = '';
            this.selectedLabel = '';
            this.search = '';
            this.isNewInput = false;
            this.isOpen = true;
        }
     }"
     @click.outside="isOpen = false">

    <input type="hidden" name="diagnosa_input" :value="selectedId">

    <div class="relative">
        <input type="text"
               x-model="search"
               @click="isOpen = true"
               @keydown.escape="isOpen = false"
               @keydown.enter.prevent="handleEnter()"
               @input="isOpen = true; selectedId = ''; isNewInput = false" 
               placeholder="Cari Kode atau Nama Penyakit..."
               class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300 pr-10 cursor-pointer"
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
         class="absolute w-full mt-1 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-md shadow-md max-h-60 overflow-y-auto z-50 py-1 custom-scrollbar"
         style="display: none;">
        
        <template x-for="option in filteredOptions" :key="option.id">
            <div @click="selectOption(option)"
                 class="cursor-pointer relative flex w-full select-none items-center rounded-sm py-1.5 pl-2 pr-8 text-sm outline-none hover:bg-slate-100 hover:text-slate-900 dark:hover:bg-slate-800 dark:hover:text-slate-50 justify-between"
                 :class="selectedId == option.id ? 'bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-slate-50' : 'text-slate-700 dark:text-slate-200'">
                <span class="font-medium" x-text="option.label"></span>
                <svg x-show="selectedId == option.id" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
        </template>

        <div x-show="filteredOptions.length === 0 && search.length > 0" 
             @click="selectNew()"
             class="px-4 py-3 text-sm cursor-pointer bg-slate-100 dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700">
            <b>Gunakan Baru:</b> "<span x-text="search"></span>"<br>
            <span class="text-xs text-slate-500">(Klik atau Tekan Enter)</span>
        </div>

        <div x-show="filteredOptions.length === 0 && search.length === 0" class="px-4 py-3 text-sm text-slate-400 italic text-center">
            Ketik untuk mencari diagnosa...
        </div>
    </div>
</div>
<p class="text-xs text-slate-500 dark:text-slate-400 mt-2 italic">
                                        * Jika diagnosa tidak ditemukan, Anda dapat mengetik diagnosa baru dan menekan <span class="font-bold">Enter</span>. Penyakit baru akan tersimpan otomatis.
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-2 block">Tindakan / Terapi Non-Obat (P)</label>
                                    <textarea name="tindakan" rows="2" class="flex w-full rounded-md border border-slate-200 bg-transparent px-3 py-2 text-sm shadow-sm transition-colors placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300" placeholder="Contoh: Edukasi diet rendah garam, Rawat luka..."></textarea>
                                </div>
                            </div>
                        </div>
@php
    // 1. Format data obat untuk JavaScript
    $medicineListJS = $medicines->map(function($m) {
        //error_log($m);
        return [
            'id' => $m->id,
            'label' => $m->name,
            'stock' => $m->current_stock, // Info stok
            'search_text' => strtolower($m->name . ' ' . $m->code) // Keyword pencarian
        ];
    });
@endphp

                        <div class="rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 p-6" 
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
        <h3 class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 flex items-center">
            <span class="bg-slate-900 dark:bg-slate-50 w-1 h-4 rounded-full mr-3"></span>
            4. Resep Obat
        </h3>
        <button type="button" @click="addRow()" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 border border-slate-200 bg-white shadow-sm hover:bg-slate-100 hover:text-slate-900 h-8 px-3 dark:border-slate-800 dark:bg-slate-950 dark:hover:bg-slate-800 dark:hover:text-slate-50">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            TAMBAH BARIS
        </button>
    </div>

    <div class="overflow-x-visible"> <table class="w-full caption-bottom text-sm">
            <thead class="[&_tr]:border-b">
                <tr class="border-b transition-colors hover:bg-slate-100/50 dark:border-slate-800 dark:hover:bg-slate-800/50">
                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 dark:text-slate-400 w-5/12">Nama Obat</th>
                    <th class="h-12 px-4 text-center align-middle font-medium text-slate-500 dark:text-slate-400 w-2/12">Qty</th>
                    <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 dark:text-slate-400 w-4/12">Aturan Pakai</th>
                    <th class="h-12 px-4 text-center align-middle font-medium text-slate-500 dark:text-slate-400 w-1/12"></th>
                </tr>
            </thead>
            <tbody class="[&_tr:last-child]:border-0">
                <template x-for="(row, index) in rows" :key="index">
                    <tr class="border-b transition-colors hover:bg-slate-100/50 dark:border-slate-800 dark:hover:bg-slate-800/50">
                        
                        <td class="p-4 align-top">
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
                                           class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300 pr-10 cursor-pointer"
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
                                     class="absolute w-full mt-1 min-w-[250px] bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-md shadow-md max-h-60 overflow-y-auto z-50 py-1 text-sm">
                                    
                                    <template x-for="item in filteredOptions" :key="item.id">
                                        <div @click="selectOption(item)"
                                             class="cursor-pointer relative flex w-full select-none items-center rounded-sm py-1.5 pl-2 pr-8 text-sm outline-none hover:bg-slate-100 hover:text-slate-900 dark:hover:bg-slate-800 dark:hover:text-slate-50 justify-between"
                                             :class="row.id == item.id ? 'bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-slate-50' : 'text-slate-700 dark:text-slate-200'">
                                            <div class="flex justify-between items-center w-full">
                                                <span class="font-medium truncate mr-2" x-text="item.label"></span>
                                                <span class="text-xs text-slate-500 dark:text-slate-400 whitespace-nowrap">
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

                        <td class="p-4 align-top">
                            <input type="number" :name="'medicines['+index+'][qty]'" x-model="row.qty" class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 dark:border-slate-800 dark:focus-visible:ring-slate-300 text-center" min="1">
                        </td>

                        <td class="p-4 align-top">
                            <input type="text" :name="'medicines['+index+'][instructions]'" x-model="row.instructions" class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300" placeholder="3 x 1 sesudah makan">
                        </td>

                        <td class="p-4 text-center align-top">
                            <button type="button" @click="removeRow(index)" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 hover:bg-red-100 hover:text-red-600 h-8 w-8 dark:hover:bg-red-900/50 dark:hover:text-red-500 bg-transparent mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
    
    <div x-show="rows.length === 0" class="text-center py-10 border border-dashed border-slate-200 dark:border-slate-800 rounded-md">
        <p class="text-slate-400 dark:text-slate-500 text-sm italic">Belum ada obat yang diresepkan.</p>
    </div>

    <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row justify-end gap-3">
        <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 bg-slate-900 text-slate-50 shadow hover:bg-slate-900/90 h-9 px-4 py-2 dark:bg-slate-50 dark:text-slate-900 dark:hover:bg-slate-50/90 w-full sm:w-auto">
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
        window.medicineOptions = @json($medicineListJS);
    </script>
</x-app-layout>