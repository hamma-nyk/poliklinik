<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">
                    {{ __('Tambah Perawat Baru') }}
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Pendaftaran tenaga keperawatan internal maupun eksternal</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-slate-500 dark:text-slate-400">
                <span class="hover:text-slate-900 dark:hover:text-slate-50 cursor-pointer transition-colors"><a href="{{ route('master.nurses.index') }}">Perawat</a></span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-900 dark:text-slate-50">Registrasi</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 p-6 sm:p-8" 
                 x-data="{ 
                    type: 'eksternal',
                    resetForm() {
                        document.getElementById('nama').value = '';
                        document.getElementById('nik').value = '';
                        document.getElementById('ktp').value = '';
                        document.getElementById('phone').value = '';
                        document.getElementById('alamat').value = '';
                    }
                 }">
                
                <h3 class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-6 flex items-center">
                    <span class="bg-slate-900 dark:bg-slate-50 w-1 h-4 rounded-full mr-3"></span>
                   Informasi biodata perawat
                </h3>

                <form action="{{ route('master.nurses.store') }}" method="POST">
                    @csrf

                    {{-- Radio Selector --}}
                    <div class="mb-8">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-3 block">Tipe Tenaga Medis</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <label class="flex items-center p-4 border rounded-md cursor-pointer transition-all duration-200" 
                                :class="type == 'karyawan' ? 'border-slate-900 bg-slate-100 dark:border-slate-50 dark:bg-slate-800' : 'border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-900/50'">
                                <input type="radio" name="type" value="karyawan" x-model="type" @change="resetForm()" class="w-4 h-4 text-slate-900 focus:ring-slate-950 border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:checked:bg-slate-50 dark:focus:ring-slate-300">
                                <div class="ml-3">
                                    <span class="block text-sm font-medium leading-none">Internal</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">Dari database karyawan</span>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-4 border rounded-md cursor-pointer transition-all duration-200"
                                :class="type == 'eksternal' ? 'border-slate-900 bg-slate-100 dark:border-slate-50 dark:bg-slate-800' : 'border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-900/50'">
                                <input type="radio" name="type" value="eksternal" x-model="type" @change="resetForm()" class="w-4 h-4 text-slate-900 focus:ring-slate-950 border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:checked:bg-slate-50 dark:focus:ring-slate-300">
                                <div class="ml-3">
                                    <span class="block text-sm font-medium leading-none">Eksternal</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">Mitra / Tenaga Luar</span>
                                </div>
                            </label>
                        </div>
                    </div>

                        {{-- Employee Selector --}}
<div x-show="type == 'karyawan'" 
     class="mb-8 rounded-md border border-sky-200 bg-sky-50 px-4 py-3 text-sm text-sky-900 shadow-sm dark:border-sky-800 dark:bg-sky-950 dark:text-sky-200 p-6">
    
    <label class="block text-xs font-semibold uppercase tracking-widest text-sky-800 dark:text-sky-400 mb-3 ml-1">Cari & Sinkron Data Karyawan</label>
    
    @php
        $employeeOptions = $employees->map(function($emp) {
            return [
                'id'      => $emp->id,
                'label'   => $emp->nik . ' - ' . $emp->nama,
                'search'  => strtolower($emp->nik . ' ' . $emp->nama),
                'nik'     => $emp->nik,
                'nama'    => $emp->nama,
                'ktp'     => $emp->ktp ?? '',
                'phone'   => $emp->phone ?? '',
                'alamat'  => $emp->alamat ?? ''
            ];
        });
    @endphp

    <div x-data="{
            open: false,
            search: '',
            selectedId: '',
            selectedLabel: '-- Pilih Karyawan --',
            items: {{ $employeeOptions }},

            get filteredItems() {
                if (this.search === '') return this.items.slice(0, 10); // Batasi 10 untuk performa
                return this.items.filter(item => item.search.includes(this.search.toLowerCase())).slice(0, 10);
            },

            selectItem(item) {
                this.selectedId = item.id;
                this.selectedLabel = item.label;
                this.open = false;
                this.search = '';

                // Auto-fill form fields
                if(document.getElementById('nik')) document.getElementById('nik').value = item.nik;
                if(document.getElementById('nama')) document.getElementById('nama').value = item.nama;
                if(document.getElementById('ktp')) document.getElementById('ktp').value = item.ktp;
                if(document.getElementById('phone')) document.getElementById('phone').value = item.phone;
                if(document.getElementById('alamat')) document.getElementById('alamat').value = item.alamat;
            }
        }" 
        class="relative w-full"
        @click.away="open = false">

        <input type="hidden" name="employee_id" x-model="selectedId">

        {{-- Trigger Button --}}
        <button type="button" 
                @click="open = !open; if(open) $nextTick(() => $refs.searchInput.focus())"
                class="flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-slate-200 bg-white px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:bg-slate-950 dark:ring-offset-slate-950 dark:placeholder:text-slate-400 dark:focus:ring-slate-300">
            
            <span x-text="selectedLabel" :class="selectedId ? 'text-slate-900 dark:text-slate-50' : 'text-slate-500 dark:text-slate-400'"></span>
            
            <svg class="h-4 w-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        {{-- Dropdown Menu --}}
        <div x-show="open" 
            class="absolute z-50 mt-1 w-full bg-white dark:bg-slate-950 rounded-md shadow-md border border-slate-200 dark:border-slate-800 overflow-hidden"
            style="display: none;">
            
            {{-- Search Input in Dropdown --}}
            <div class="p-2 border-b border-slate-100 dark:border-slate-800">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input x-ref="searchInput" 
                        x-model="search" 
                        type="text" 
                        placeholder="Ketik NIK atau Nama..." 
                        class="flex h-8 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 pl-8 text-sm shadow-sm transition-colors placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">
                </div>
            </div>

            {{-- Items List --}}
            <ul class="max-h-64 overflow-y-auto p-1">
                <template x-for="item in filteredItems" :key="item.id">
                    <li @click="selectItem(item)" 
                        class="cursor-pointer relative flex w-full select-none items-center rounded-sm py-1.5 pl-2 pr-8 text-sm outline-none hover:bg-slate-100 hover:text-slate-900 data-[disabled]:pointer-events-none data-[disabled]:opacity-50 dark:hover:bg-slate-800 dark:hover:text-slate-50">
                        <span x-text="item.label"></span>
                    </li>
                </template>
                
                {{-- Empty State --}}
                <div x-show="filteredItems.length === 0" class="py-6 text-center text-sm text-slate-500 dark:text-slate-400">
                    Data karyawan tidak ditemukan.
                </div>
            </ul>
        </div>
    </div>
</div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- NIK Karyawan --}}
                            <div x-show="type == 'karyawan'" class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">NIK Perusahaan</label>
                                <input type="text" name="nik" id="nik" class="flex h-9 w-full rounded-md border border-slate-200 bg-slate-100 px-3 py-1 text-sm shadow-sm transition-colors dark:border-slate-800 dark:bg-slate-800 dark:text-slate-400 font-mono" readonly placeholder="Otomatis...">
                            </div>

                            {{-- NIK KTP --}}
                            <div :class="type == 'eksternal' ? 'col-span-2 space-y-2' : 'space-y-2'">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">KTP</label>
                                <input type="text" name="ktp" id="ktp" class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300" placeholder="16 digit nomor KTP">
                            </div>
                        </div>

                        {{-- Nama --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nama Lengkap <span class="text-destructive">*</span></label>
                            <input type="text" name="nama" id="nama" class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300" :class="type == 'karyawan' ? 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400' : ''" :readonly="type == 'karyawan'" required>
                        </div>

                        {{-- STR --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">No. STR (Surat Tanda Registrasi)</label>
                            <input type="text" name="str" class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300" placeholder="Nomor STR aktif">
                        </div>

                        {{-- HP --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">No. HP / WhatsApp</label>
                            <input type="text" name="phone" id="phone" class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300" placeholder="08xxxxxxxxxx">
                        </div>

                        {{-- Alamat --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Alamat Domisili</label>
                            <textarea name="alamat" id="alamat" class="flex min-h-[80px] w-full rounded-md border border-slate-200 bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300" rows="3"></textarea>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('master.nurses.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 border border-slate-200 bg-white shadow-sm hover:bg-slate-100 hover:text-slate-900 h-9 px-4 py-2 dark:border-slate-800 dark:bg-slate-950 dark:hover:bg-slate-800 dark:hover:text-slate-50">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 bg-slate-900 text-slate-50 shadow hover:bg-slate-900/90 h-9 px-4 py-2 dark:bg-slate-50 dark:text-slate-900 dark:hover:bg-slate-50/90">
                            Simpan Perawat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>