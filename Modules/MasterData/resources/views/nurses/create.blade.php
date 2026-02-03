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
                        <select id="employee_selector" name="employee_id" class="w-full rounded-xl border-emerald-200 dark:border-emerald-800 bg-white dark:bg-slate-800 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5">
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" 
                                    data-nik="{{ $emp->nik }}"
                                    data-nama="{{ $emp->nama }}"
                                    data-ktp="{{ $emp->ktp ?? '' }}"
                                    data-phone="{{ $emp->phone }}"
                                    data-alamat="{{ $emp->alamat }}">
                                    {{ $emp->nik }} - {{ $emp->nama }}
                                </option>
                            @endforeach
                        </select>
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