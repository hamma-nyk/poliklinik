<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">
                    {{ __('Registrasi Pasien Baru') }}
                </h2>
                <p class="text-sm text-neutral-500 mt-1 dark:text-neutral-400">Pendaftaran pasien baru ke dalam sistem rekam medis</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-neutral-500 mt-2 md:mt-0 dark:text-neutral-400">
                <span class="hover:text-neutral-900 dark:hover:text-neutral-50 cursor-pointer transition-colors"><a href="{{ route('master.patients.index') }}">Pasien</a></span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Registrasi</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-8" x-data="{ tab: 'employee' }">
                <h3 class="text-xs font-semibold uppercase tracking-widest text-neutral-500 dark:text-neutral-400 mb-6 flex items-center">
                    <span class="bg-neutral-900 dark:bg-neutral-50 w-1 h-4 rounded-full mr-3"></span>
                    Informasi Biodata Pasien
                </h3>
                <form action="{{ route('master.patients.store') }}" method="POST">
                    @csrf
                    
                    {{-- Tab Switcher --}}
                    <div class="flex p-1 space-x-1 rounded-md border border-neutral-200 dark:border-neutral-600 bg-neutral-100 dark:bg-neutral-800 mb-8">
                        <button type="button" @click="tab = 'employee'"
                                :class="tab === 'employee' ? 'bg-white dark:bg-neutral-800 shadow text-neutral-900 dark:text-neutral-50' : 'text-neutral-500 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-50'"
                                class="w-full py-2.5 text-sm font-medium leading-5 rounded-md transition-all duration-200">
                            Pilih dari Karyawan
                        </button>
                        <button type="button" @click="tab = 'general'"
                                :class="tab === 'general' ? 'bg-white dark:bg-neutral-800 shadow text-neutral-900 dark:text-neutral-50' : 'text-neutral-500 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-50'"
                                class="w-full py-2.5 text-sm font-medium leading-5 rounded-md transition-all duration-200">
                            Input Manual (Umum)
                        </button>
                    </div>
                    
                    <input type="hidden" name="registration_type" x-model="tab">

                    {{-- Tab: Employee --}}
                    <div x-show="tab === 'employee'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2">
                        <div class="rounded-md border border-sky-200 bg-sky-50 px-4 py-3 text-sm text-sky-900 shadow-sm dark:border-sky-800 dark:bg-sky-950 dark:text-sky-200 mb-6">
                            <p class="flex items-start">
                                <svg class="w-5 h-5 mr-3 shrink-0 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Data biodata akan disinkronkan otomatis dari Database HR. Pasien akan terhubung secara permanen dengan ID Karyawan tersebut.
                            </p>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Cari Nama Karyawan <span class="text-destructive">*</span></label>
                            @php
                                $employeeOptions = $employees->map(function($emp) {
                                    $subDeptName = $emp->subDepartment->name ?? '-';
                                    return [
                                        'id' => $emp->id,
                                        'label' => $emp->nama . ' — ' . $subDeptName . ' (' . $emp->nik . ')',
                                        'search_text' => strtolower($emp->nama . ' ' . $subDeptName . ' ' . $emp->nik)
                                    ];
                                });
                            @endphp

<div x-data="{
        open: false,
        search: '',
        selectedId: '',
        selectedLabel: '',
        items: {{ $employeeOptions }},
        
        // Fungsi untuk menyaring data berdasarkan ketikan
        get filteredItems() {
            if (this.search === '') return this.items;
            return this.items.filter(item => item.search_text.includes(this.search.toLowerCase()));
        },

        // Fungsi saat item dipilih
        selectItem(item) {
            this.selectedId = item.id;
            this.selectedLabel = item.label;
            this.search = ''; // Reset search (opsional)
            this.open = false;
        },

        // Fungsi inisialisasi (opsional, jika halaman edit)
        init() {
            // Jika ada old input (validasi error)
            @if(old('employee_id'))
                const oldItem = this.items.find(i => i.id == '{{ old('employee_id') }}');
                if(oldItem) this.selectItem(oldItem);
            @endif
        }
    }" 
    class="relative w-full"
    @click.away="open = false">

    <input type="hidden" name="employee_id" x-model="selectedId">

    <button type="button" 
            @click="open = !open; $nextTick(() => $refs.searchInput.focus())"
            class="flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-neutral-200 bg-white px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-neutral-500 focus:outline-none focus:ring-1 focus:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:bg-neutral-800 dark:ring-offset-neutral-950 dark:placeholder:text-neutral-400 dark:focus:ring-neutral-300">
        
        <span x-text="selectedId ? selectedLabel : '-- Pilih Karyawan Aktif --'" 
              :class="selectedId ? 'font-medium' : 'text-neutral-500 dark:text-neutral-400'"></span>
        
        <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         class="absolute z-50 mt-1 w-full bg-white dark:bg-neutral-800 rounded-md shadow-md border border-neutral-200 dark:border-neutral-600 overflow-hidden"
         style="display: none;">
        
        <div class="p-2 border-b border-neutral-200 dark:border-neutral-600">
            <input x-ref="searchInput" 
                   x-model="search" 
                   type="text" 
                   placeholder="Cari nama, nik, atau departemen..." 
                   class="flex h-8 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
        </div>

        <ul class="max-h-60 overflow-y-auto">
            <template x-for="item in filteredItems" :key="item.id">
                <li @click="selectItem(item)" 
                    class="cursor-pointer relative flex w-full select-none items-center rounded-sm py-1.5 pl-2 pr-8 text-sm outline-none hover:bg-neutral-100 hover:text-neutral-900 dark:hover:bg-neutral-700 dark:hover:text-neutral-50"
                    :class="{'bg-neutral-100 dark:bg-neutral-800 font-semibold': selectedId === item.id}">
                    <span x-text="item.label"></span>
                </li>
            </template>
            
            <li x-show="filteredItems.length === 0" class="px-4 py-3 text-sm text-neutral-500 text-center italic">
                Data tidak ditemukan.
            </li>
        </ul>
    </div>
</div>
                        </div>
                    </div>

                    {{-- Tab: General --}}
                    <div x-show="tab === 'general'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2 space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nama Lengkap <span class="text-destructive">*</span></label>
                                <input type="text" name="name" placeholder="Nama sesuai identitas" class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">KTP <span class="text-destructive">*</span></label>
                                <input type="text" name="ktp" placeholder="16 digit NIK" class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Tanggal Lahir</label>
                                <input type="date" name="birth_date" class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Jenis Kelamin</label>
                                <select name="gender" class="flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-neutral-500 focus:outline-none focus:ring-1 focus:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:ring-offset-neutral-950 dark:placeholder:text-neutral-400 dark:focus:ring-neutral-300">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">No. Telepon / WA</label>
                                <input type="text" name="phone" placeholder="08..." class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                            </div>
                            <div class="md:col-span-2 space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Alamat Domisili</label>
                                <textarea name="address" rows="2" class="flex min-h-[80px] w-full rounded-md border border-neutral-200 bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300"></textarea>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Golongan Darah</label>
                                <select name="blood_type" class="flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-neutral-500 focus:outline-none focus:ring-1 focus:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:ring-offset-neutral-950 dark:placeholder:text-neutral-400 dark:focus:ring-neutral-300">
                                    <option value="">- Pilih -</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Section Alergi --}}
                    <div class="mt-8 pt-6 border-t border-neutral-200 dark:border-neutral-600">
                        <label class="text-sm font-medium text-destructive mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Riwayat Alergi Obat & Catatan Medis Khusus
                        </label>
                        <textarea name="allergies" rows="2" 
                            class="flex min-h-[80px] w-full rounded-md border border-destructive/20 bg-destructive/5 px-3 py-2 text-sm shadow-sm placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300" 
                            placeholder="Contoh: Alergi Amoxicillin, Riwayat Asma..."></textarea>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-8 pt-6 border-t border-neutral-200 dark:border-neutral-600 flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('master.patients.index') }}" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50">
                            Batal
                        </a>
                        <button type="submit" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-4 py-2 dark:bg-neutral-50 dark:text-neutral-900 dark:hover:bg-neutral-50/90">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Data Pasien
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
