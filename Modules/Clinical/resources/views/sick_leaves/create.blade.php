<x-app-layout title="Buat Surat Keterangan Dokter">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 transition-all duration-300">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-100 leading-tight tracking-tight">
                    {{ __('Buat Surat Keterangan Dokter') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Arsip digital surat keterangan sakit & izin medis</p>
            </div>
            <a href="{{ route('clinical.sick-leaves.index') }}" class="px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-600 dark:text-slate-300 text-sm font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all active:scale-95">
                Batal
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300" x-data="skdHandler()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('clinical.sick-leaves.store') }}" method="POST">
                @csrf
                
                <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                    
                    {{-- Header Form --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 border-b border-slate-100 dark:border-slate-700 pb-8">
                        <div class="space-y-1">
                            <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] ml-1">Nomor Registrasi Surat</label>
                            <input type="text" name="reg_number" value="{{ $regNumber }}" readonly 
                                class="w-full bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-slate-700 rounded-2xl font-mono font-bold text-indigo-600 dark:text-indigo-400 focus:ring-0">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] ml-1">Kategori Sumber SKD</label>
                            <div class="flex gap-3">
                                <label class="flex-1 flex items-center justify-center cursor-pointer p-3 border-2 rounded-2xl transition-all"
                                    :class="type === 'internal' ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300' : 'border-slate-100 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-400'">
                                    <input type="radio" name="type" value="internal" x-model="type" class="hidden">
                                    <span class="font-bold text-sm">Internal</span>
                                </label>
                                <label class="flex-1 flex items-center justify-center cursor-pointer p-3 border-2 rounded-2xl transition-all"
                                    :class="type === 'external' ? 'border-orange-500 bg-orange-50 dark:bg-orange-900/20 text-orange-700 dark:text-orange-300' : 'border-slate-100 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-400'">
                                    <input type="radio" name="type" value="external" x-model="type" class="hidden">
                                    <span class="font-bold text-sm">Eksternal</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION: INTERNAL (Searchable MR) --}}
                    <div x-show="type === 'internal'" x-transition class="mb-8 p-6 bg-indigo-50/30 dark:bg-slate-900/40 rounded-2xl border border-indigo-100 dark:border-slate-700">
                        <label class="block text-sm font-bold text-indigo-900 dark:text-indigo-300 mb-3 ml-1">Integrasi Rekam Medis Pasien</label>
                        <select id="mr_select" name="medical_record_id" x-ref="mrSelect" class="w-full rounded-2xl">
                            <option value="">-- Cari Nama Pasien atau No. RM --</option>
                            @foreach($internalCandidates as $mr)
                                <option value="{{ $mr->id }}" data-date="{{ $mr->created_at->format('Y-m-d') }}">
                                    {{ $mr->patient->name }} ({{ $mr->patient->code }}) — {{ $mr->created_at->format('d/m/Y H:i') }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-indigo-500 dark:text-indigo-400/60 mt-3 flex items-center italic">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"/></svg>
                            Menampilkan data yang ditandai "Ijin Sakit" saat pemeriksaan.
                        </p>
                    </div>

                    {{-- SECTION: EXTERNAL (Searchable Patient) --}}
                    <div x-show="type === 'external'" x-transition class="mb-8 p-6 bg-orange-50/30 dark:bg-slate-900/40 rounded-2xl border border-orange-100 dark:border-slate-700">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-3 ml-1">Data Karyawan / Pasien</label>
                                <select id="patient_select" name="patient_id" x-ref="patientSelect" class="w-full">
                                    <option value="">-- Ketik Nama atau NIK --</option>
                                    @foreach($patients as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }} — {{ $p->nik }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Klinik / RS Penerbit</label>
                                <input type="text" name="external_clinic_name" placeholder="Nama RS Luar" 
                                    class="w-full rounded-2xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 focus:ring-orange-500">
                            </div>
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Dokter Luar</label>
                                <input type="text" name="external_doctor_name" placeholder="Nama Dokter Pemeriksa" 
                                    class="w-full rounded-2xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 focus:ring-orange-500">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 items-start">
    
    {{-- Mulai Tanggal --}}
    <div class="space-y-2">
        <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Mulai Tanggal</label>
        <input type="date" name="start_date" x-model="startDate" 
            class="w-full h-12 rounded-2xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
    </div>

    {{-- Durasi Izin --}}
    <div class="space-y-2">
        <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Durasi Izin</label>
        <div class="relative flex items-center">
            <input type="number" name="days" x-model="days" min="1" 
                class="w-full h-12 rounded-2xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 pr-16 font-bold text-indigo-600 dark:text-indigo-400">
            <div class="absolute right-4 flex items-center pointer-events-none border-l border-slate-200 dark:border-slate-700 pl-3 h-6">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">Hari</span>
            </div>
        </div>
    </div>

    {{-- Selesai Tanggal --}}
    <div class="space-y-2">
        <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Selesai Tanggal</label>
        <div class="w-full h-12 px-5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl flex items-center group transition-colors">
            <svg class="w-4 h-4 text-slate-300 dark:text-slate-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span class="text-sm font-semibold text-slate-600 dark:text-slate-300" x-text="calculateEndDate()"></span>
        </div>
    </div>
</div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Diagnosa / Catatan Medis</label>
                        <textarea name="notes" rows="3" 
                            class="w-full rounded-2xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 focus:ring-indigo-500 p-4 text-sm" 
                            placeholder="Tuliskan alasan medis atau diagnosa singkat..."></textarea>
                    </div>

                    {{-- Footer Action --}}
                    <div class="mt-10 flex flex-col md:flex-row justify-end gap-4">
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 italic max-w-xs text-right self-center mr-4">Pastikan data yang diinput sesuai dengan rekam medis atau bukti fisik dari RS luar.</p>
                        <button type="submit" 
                            class="px-10 py-4 rounded-2xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 shadow-xl shadow-indigo-500/20 transform hover:-translate-y-1 active:scale-95 transition-all uppercase tracking-widest text-xs">
                            Simpan & Terbitkan SKD
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    

    @push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <style>
        /* TomSelect Dark Mode Styling */
        .ts-wrapper.single .ts-control { border-radius: 1rem; padding: 0.6rem 1rem; border-color: #e2e8f0; }
        .dark .ts-wrapper.single .ts-control { background-color: #1e293b; border-color: #334155; color: #f1f5f9; }
        .dark .ts-dropdown { background-color: #1e293b; border-color: #334155; color: #f1f5f9; }
        .dark .ts-dropdown .active { background-color: #4f46e5; color: #fff; }
        .dark .ts-dropdown .option { color: #cbd5e1; }
    </style>
    <script>
        function skdHandler() {
            return {
                type: 'internal',
                startDate: '{{ date("Y-m-d") }}',
                days: 1,
                
                init() {
                    // Initialize TomSelect for Internal MR
                    new TomSelect(this.$refs.mrSelect, {
                        onChange: (value) => {
                            if (value) {
                                const option = this.$refs.mrSelect.options[this.$refs.mrSelect.selectedIndex];
                                this.startDate = option.dataset.date;
                            }
                        }
                    });

                    // Initialize TomSelect for External Patient
                    new TomSelect(this.$refs.patientSelect, {
                        create: false,
                        sortField: { field: "text", order: "asc" }
                    });
                },

                calculateEndDate() {
                if (!this.startDate || !this.days || this.days < 1) return 'Pilih durasi...';
                
                const date = new Date(this.startDate);
                // Ditambah durasi minus 1 karena hari mulai dihitung sebagai hari pertama
                date.setDate(date.getDate() + (parseInt(this.days) - 1));
                
                return new Intl.DateTimeFormat('id-ID', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                }).format(date);
            }
            }
        }
    </script>

    @endpush
</x-app-layout>