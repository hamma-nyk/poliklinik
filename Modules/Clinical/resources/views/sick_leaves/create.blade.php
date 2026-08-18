<x-app-layout title="Buat Surat Keterangan Dokter">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 transition-all duration-300">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight text-neutral-800 dark:text-neutral-100">
                    {{ __('Buat Surat Keterangan Dokter') }}
                </h2>
                <p class="text-sm text-neutral-500 mt-1 dark:text-neutral-400">Arsip digital surat keterangan sakit & izin medis</p>
            </div>
            <a href="{{ route('clinical.sick-leaves.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50">
                Batal
            </a>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4" x-data="skdHandler()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('clinical.sick-leaves.store') }}" method="POST">
                @csrf
                
                <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-6">
                    
                    {{-- Header Form --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 border-b border-neutral-200 dark:border-neutral-600 pb-8">
                        <div class="space-y-1">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nomor Registrasi Surat</label>
                            <input type="text" name="reg_number" value="{{ $regNumber }}" readonly 
                                class="flex h-9 w-full rounded-md border border-neutral-200 bg-neutral-100 px-3 py-1 text-sm shadow-sm transition-colors dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-400 font-mono cursor-not-allowed">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Kategori Sumber SKD</label>
                            <div class="flex gap-3">
                                <label class="flex-1 flex items-center p-4 border rounded-md cursor-pointer transition-all duration-200"
                                    :class="type === 'internal' ? 'border-neutral-900 bg-neutral-100 dark:border-neutral-50 dark:bg-neutral-800' : 'border-neutral-200 dark:border-neutral-600 hover:bg-neutral-50 dark:hover:bg-neutral-700/50'">
                                    <input type="radio" name="type" value="internal" x-model="type" class="w-4 h-4 text-neutral-900 focus:ring-neutral-950 border-neutral-300 dark:border-neutral-600 dark:bg-neutral-800 dark:checked:bg-neutral-50 dark:focus:ring-neutral-300">
                                    <span class="block text-sm font-medium leading-none ml-2">Internal</span>
                                </label>
                                <label class="flex-1 flex items-center p-4 border rounded-md cursor-pointer transition-all duration-200"
                                    :class="type === 'external' ? 'border-neutral-900 bg-neutral-100 dark:border-neutral-50 dark:bg-neutral-800' : 'border-neutral-200 dark:border-neutral-600 hover:bg-neutral-50 dark:hover:bg-neutral-700/50'">
                                    <input type="radio" name="type" value="external" x-model="type" class="w-4 h-4 text-neutral-900 focus:ring-neutral-950 border-neutral-300 dark:border-neutral-600 dark:bg-neutral-800 dark:checked:bg-neutral-50 dark:focus:ring-neutral-300">
                                    <span class="block text-sm font-medium leading-none ml-2">Eksternal</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION: INTERNAL (Searchable MR) --}}
                    <div x-show="type === 'internal'" x-transition class="mb-8 rounded-md border border-neutral-200 bg-neutral-50 dark:bg-neutral-800 dark:border-neutral-600 p-6">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 block mb-3">Integrasi Rekam Medis Pasien</label>
                        <select id="mr_select" name="medical_record_id" x-ref="mrSelect" class="flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:ring-offset-neutral-950 dark:placeholder:text-neutral-400 dark:focus:ring-neutral-300">
                            <option value="">-- Cari Nama Pasien atau No. RM --</option>
                            @foreach($internalCandidates as $mr)
                                <option value="{{ $mr->id }}" data-date="{{ $mr->created_at->format('Y-m-d') }}">
                                    {{ $mr->patient->name }} ({{ $mr->patient->code }}) — {{ $mr->created_at->format('d/m/Y H:i') }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-3 flex items-center italic">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"/></svg>
                            Menampilkan data yang ditandai "Ijin Sakit" saat pemeriksaan.
                        </p>
                    </div>

                    {{-- SECTION: EXTERNAL (Searchable Patient) --}}
                    <div x-show="type === 'external'" x-transition class="mb-8 rounded-md border border-neutral-200 bg-neutral-50 dark:bg-neutral-800 dark:border-neutral-600 p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 block mb-3">Data Karyawan / Pasien</label>
                                <select id="patient_select" name="target_person" x-ref="patientSelect" class="flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:ring-offset-neutral-950 dark:placeholder:text-neutral-400 dark:focus:ring-neutral-300">
                                    <option value="">-- Ketik Nama atau NIK --</option>
                                    @foreach($externalCandidates as $candidate)
                                        <option value="{{ $candidate['value'] }}">
                                            {{ $candidate['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Klinik / RS Penerbit</label>
                                <input type="text" name="external_clinic_name" placeholder="Nama RS Luar" 
                                    class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Dokter Luar</label>
                                <input type="text" name="external_doctor_name" placeholder="Nama Dokter Pemeriksa" 
                                    class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 items-start">
    
    {{-- Mulai Tanggal --}}
    <div class="space-y-2">
        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Mulai Tanggal</label>
        <input type="date" name="start_date" x-model="startDate" 
            class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
    </div>

    {{-- Durasi Izin --}}
    <div class="space-y-2">
        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Durasi Izin</label>
        <div class="relative flex items-center">
            <input type="number" name="days" x-model="days" min="1" 
                class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300 pr-16 font-bold">
            <div class="absolute right-4 flex items-center pointer-events-none pl-3 h-6">
                <span class="text-xs font-semibold text-neutral-500">Hari</span>
            </div>
        </div>
    </div>

    {{-- Selesai Tanggal --}}
    <div class="space-y-2">
        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Selesai Tanggal</label>
        <div class="w-full h-9 px-3 border border-neutral-200 dark:border-neutral-600 rounded-md flex items-center group transition-colors">
            <svg class="w-4 h-4 text-neutral-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span class="text-sm text-neutral-600 dark:text-neutral-300" x-text="calculateEndDate()"></span>
        </div>
    </div>
</div>

                    <div class="space-y-1">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 block mb-2">Diagnosa / Catatan Medis</label>
                        <textarea name="notes" rows="3" 
                            class="flex min-h-[80px] w-full rounded-md border border-neutral-200 bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300" 
                            placeholder="Tuliskan alasan medis atau diagnosa singkat..."></textarea>
                    </div>

                    {{-- Footer Action --}}
                    <div class="mt-8 pt-6 border-t border-neutral-200 dark:border-neutral-600 flex flex-col sm:flex-row justify-end gap-3">
                        <p class="text-xs text-neutral-500 italic text-right self-center mr-4">Pastikan data yang diinput sesuai dengan rekam medis atau bukti fisik dari RS luar.</p>
                        <button type="submit" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-4 py-2 dark:bg-neutral-50 dark:text-neutral-900 dark:hover:bg-neutral-50/90">
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
    .ts-wrapper.single .ts-control { 
        border-radius: 0.375rem !important; 
        padding: 0.25rem 0.75rem !important; 
        height: 36px !important;
        border-color: #e2e8f0 !important; 
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05) !important;
        font-size: 0.875rem !important;
        display: flex;
        align-items: center;
        background-color: transparent !important;
    }
    .dark .ts-wrapper.single .ts-control { 
        border-color: #1e293b !important; 
        color: #f8fafc !important; 
    }
    .ts-wrapper.single .ts-control input {
        font-size: 0.875rem !important;
    }
    .dark .ts-wrapper.single .ts-control input {
        color: #f8fafc !important;
    }
    .ts-dropdown { 
        border-radius: 0.375rem !important;
        border-color: #e2e8f0 !important;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1) !important;
        font-size: 0.875rem !important;
        z-index: 50 !important;
    }
    .dark .ts-dropdown { 
        background-color: #020617 !important; 
        border-color: #1e293b !important; 
        color: #f8fafc !important; 
    }
    .ts-dropdown .option {
        padding: 8px 12px !important;
    }
    .ts-dropdown .active { 
        background-color: #f1f5f9 !important; 
        color: #0f172a !important; 
    }
    .dark .ts-dropdown .active { 
        background-color: #1e293b !important; 
        color: #f8fafc !important; 
    }
    .dark .ts-dropdown .option { 
        color: #cbd5e1; 
    }
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