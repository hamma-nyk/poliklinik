<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Tambah Perawat') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Pendaftaran tenaga keperawatan internal maupun eksternal</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-slate-500 mt-2 md:mt-0 dark:text-slate-400">
                <span class="hover:text-emerald-600 cursor-pointer transition-colors">Perawat</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Registrasi Baru</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 transition-all" 
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
                
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-6 flex items-center">
                    <span class="w-1.5 h-6 bg-emerald-500 rounded-full mr-3"></span>
                    Konfigurasi Kepegawaian
                </h3>

                <form action="{{ route('master.nurses.store') }}" method="POST">
                    @csrf

                    {{-- Radio Selector --}}
                    <div class="mb-8">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-3">Tipe Tenaga Medis</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <label class="flex items-center p-4 border rounded-xl cursor-pointer transition-all duration-200" 
                                   :class="type == 'karyawan' ? 'border-emerald-500 bg-emerald-50 dark:bg-emerald-900/20 ring-1 ring-emerald-500' : 'border-slate-200 dark:border-slate-700 dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700'">
                                <input type="radio" name="type" value="karyawan" x-model="type" @change="resetForm()" class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 border-slate-300">
                                <div class="ml-3">
                                    <span class="block font-bold text-slate-700 dark:text-slate-200">Internal</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">Dari database karyawan</span>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-4 border rounded-xl cursor-pointer transition-all duration-200"
                                   :class="type == 'eksternal' ? 'border-emerald-500 bg-emerald-50 dark:bg-emerald-900/20 ring-1 ring-emerald-500' : 'border-slate-200 dark:border-slate-700 dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700'">
                                <input type="radio" name="type" value="eksternal" x-model="type" @change="resetForm()" class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 border-slate-300">
                                <div class="ml-3">
                                    <span class="block font-bold text-slate-700 dark:text-slate-200">Eksternal</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">Mitra / Tenaga Luar</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Employee Selector --}}
                    <div x-show="type == 'karyawan'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" class="mb-8 bg-emerald-50 dark:bg-emerald-900/10 p-5 rounded-xl border border-emerald-100 dark:border-emerald-800/30">
                        <label class="block font-bold text-emerald-800 dark:text-emerald-400 text-sm mb-2">Cari & Sinkron Data Karyawan</label>
                        @php
    $employeeOptions = $employees->map(function($emp) {
        return [
            'id'      => $emp->id,
            // Gabungkan NIK dan Nama untuk label & pencarian
            'label'   => $emp->nik . ' - ' . $emp->nama,
            'search'  => strtolower($emp->nik . ' ' . $emp->nama),
            
            // Data tambahan (pengganti data-* attributes)
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

        // Filter pencarian
        get filteredItems() {
            if (this.search === '') return this.items;
            return this.items.filter(item => item.search.includes(this.search.toLowerCase()));
        },

        // Saat item dipilih
        selectItem(item) {
            this.selectedId = item.id;
            this.selectedLabel = item.label;
            this.open = false;
            this.search = '';

            // --- LOGIKA AUTO-FILL FORM ---
            // Karena native <select> hilang, kita isi input lain secara manual di sini.
            // Sesuaikan ID elemen di bawah dengan ID input di form Anda.
            
            if(document.getElementById('nik')) document.getElementById('nik').value = item.nik;
            if(document.getElementById('nama'))         document.getElementById('nama').value = item.nama;
            if(document.getElementById('ktp'))      document.getElementById('ktp').value = item.ktp;
            if(document.getElementById('phone'))        document.getElementById('phone').value = item.phone;
            if(document.getElementById('address'))      document.getElementById('address').value = item.alamat;
        }
    }" 
    class="relative w-full"
    @click.away="open = false">

    <input type="hidden" name="employee_id" x-model="selectedId">

    <button type="button" 
            @click="open = !open; $nextTick(() => $refs.searchInput.focus())"
            class="w-full text-left rounded-xl border border-emerald-200 dark:border-emerald-800 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 py-2.5 px-3 flex justify-between items-center shadow-sm transition-colors">
        
        <span x-text="selectedLabel" :class="selectedId ? 'font-medium' : 'text-slate-400'"></span>
        
        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute z-50 mt-1 w-full bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-emerald-100 dark:border-emerald-800 overflow-hidden"
         style="display: none;">
        
        <div class="p-2 border-b border-emerald-50 dark:border-emerald-900">
            <input x-ref="searchInput" 
                   x-model="search" 
                   type="text" 
                   placeholder="Cari NIK atau Nama..." 
                   class="w-full text-sm rounded-lg border-emerald-200 dark:border-emerald-700 bg-emerald-50 dark:bg-slate-900 text-slate-800 dark:text-slate-200 focus:ring-emerald-500 focus:border-emerald-500">
        </div>

        <ul class="max-h-60 overflow-y-auto">
            <template x-for="item in filteredItems" :key="item.id">
                <li @click="selectItem(item)" 
                    class="cursor-pointer px-4 py-2 text-sm hover:bg-emerald-50 dark:hover:bg-emerald-900/30 text-slate-700 dark:text-slate-300 transition-colors border-b border-slate-50 dark:border-slate-700/50 last:border-0"
                    :class="{'bg-emerald-50 dark:bg-emerald-900/50 font-bold text-emerald-700 dark:text-emerald-400': selectedId === item.id}">
                    <span x-text="item.label"></span>
                </li>
            </template>
            
            <li x-show="filteredItems.length === 0" class="px-4 py-3 text-sm text-slate-500 text-center italic">
                Karyawan tidak ditemukan.
            </li>
        </ul>
    </div>
</div>
                    </div>

                    <div class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {{-- NIK Karyawan --}}
                            <div x-show="type == 'karyawan'" x-transition>
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">NIK Perusahaan</label>
                                <input type="text" name="nik" id="nik" class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-700/50 dark:text-slate-400 font-mono text-sm" readonly placeholder="Otomatis...">
                            </div>

                            {{-- NIK KTP --}}
                            <div :class="type == 'eksternal' ? 'col-span-2' : ''">
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">NIK (KTP)</label>
                                <input type="text" name="ktp" id="ktp" class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-700 dark:text-slate-100 focus:border-emerald-500 focus:ring-emerald-500" placeholder="16 digit nomor KTP">
                            </div>
                        </div>

                        {{-- Nama --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" id="nama" class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:text-slate-100 focus:border-emerald-500 focus:ring-emerald-500" :class="type == 'karyawan' ? 'bg-slate-100 dark:bg-slate-700/50' : 'bg-white dark:bg-slate-700'" :readonly="type == 'karyawan'" required>
                        </div>

                        {{-- STR --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">No. STR (Surat Tanda Registrasi)</label>
                            <input type="text" name="str" class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-700 dark:text-slate-100 focus:border-emerald-500 focus:ring-emerald-500" placeholder="Nomor STR aktif">
                        </div>

                        {{-- HP --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">No. HP / WhatsApp</label>
                            <input type="text" name="phone" id="phone" class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-700 dark:text-slate-100 focus:border-emerald-500 focus:ring-emerald-500" placeholder="08xxxxxxxxxx">
                        </div>

                        {{-- Alamat --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Alamat Domisili</label>
                            <textarea name="alamat" id="alamat" class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-700 dark:text-slate-100 focus:border-emerald-500 focus:ring-emerald-500" rows="3"></textarea>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="mt-10 flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('master.nurses.index') }}" class="inline-flex justify-center items-center px-6 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex justify-center items-center px-8 py-2.5 rounded-xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 dark:shadow-none transition transform hover:-translate-y-0.5">
                            Simpan Perawat
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.getElementById('employee_selector').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            
            if (this.value) {
                var nik = selectedOption.getAttribute('data-nik');
                var nama = selectedOption.getAttribute('data-nama');
                var ktp = selectedOption.getAttribute('data-ktp');
                var phone = selectedOption.getAttribute('data-phone');
                var alamat = selectedOption.getAttribute('data-alamat');

                document.getElementById('nik').value = nik;
                document.getElementById('nama').value = nama;
                document.getElementById('ktp').value = ktp || '';
                document.getElementById('phone').value = phone || '';
                document.getElementById('alamat').value = alamat || '';
            } else {
                document.getElementById('nik').value = '';
                document.getElementById('nama').value = '';
                document.getElementById('ktp').value = '';
                document.getElementById('phone').value = '';
                document.getElementById('alamat').value = '';
            }
        });
    </script>
</x-app-layout>