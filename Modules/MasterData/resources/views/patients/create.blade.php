<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Registrasi Pasien Baru') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Pendaftaran pasien baru ke dalam sistem rekam medis</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-slate-500 mt-2 md:mt-0 dark:text-slate-400">
                <span class="hover:text-blue-600 cursor-pointer transition-colors">Pasien</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Registrasi</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700 p-8" x-data="{ tab: 'employee' }">
                
                <form action="{{ route('master.patients.store') }}" method="POST">
                    @csrf
                    
                    {{-- Tab Switcher --}}
                    <div class="flex p-1 space-x-1 bg-slate-100 dark:bg-slate-700 rounded-xl mb-8">
                        <button type="button" @click="tab = 'employee'"
                                :class="tab === 'employee' ? 'bg-white dark:bg-slate-600 shadow text-blue-700 dark:text-blue-300' : 'text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200'"
                                class="w-full py-2.5 text-sm font-bold leading-5 rounded-lg transition-all duration-200">
                            Pilih dari Karyawan
                        </button>
                        <button type="button" @click="tab = 'general'"
                                :class="tab === 'general' ? 'bg-white dark:bg-slate-600 shadow text-blue-700 dark:text-blue-300' : 'text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200'"
                                class="w-full py-2.5 text-sm font-bold leading-5 rounded-lg transition-all duration-200">
                            Input Manual (Umum)
                        </button>
                    </div>
                    
                    <input type="hidden" name="registration_type" x-model="tab">

                    {{-- Tab: Employee --}}
                    <div x-show="tab === 'employee'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2">
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/30 rounded-xl p-4 mb-6">
                            <p class="text-sm text-blue-800 dark:text-blue-300 flex items-start">
                                <svg class="w-5 h-5 mr-3 shrink-0 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Data biodata akan disinkronkan otomatis dari Database HR. Pasien akan terhubung secara permanen dengan ID Karyawan tersebut.
                            </p>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Cari Nama Karyawan <span class="text-red-500">*</span></label>
                            <select name="employee_id" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 py-2.5">
                                <option value="">-- Pilih Karyawan Aktif --</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">
                                        {{ $emp->nama }} — {{ $emp->bag_dept }} ({{ $emp->nik }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Tab: General --}}
                    <div x-show="tab === 'general'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2 space-y-2">
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="name" placeholder="Nama sesuai identitas" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">NIK KTP <span class="text-red-500">*</span></label>
                                <input type="text" name="nik_ktp" placeholder="16 digit NIK" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Tanggal Lahir</label>
                                <input type="date" name="birth_date" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Jenis Kelamin</label>
                                <select name="gender" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">No. Telepon / WA</label>
                                <input type="text" name="phone" placeholder="08..." class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div class="md:col-span-2 space-y-2">
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Alamat Domisili</label>
                                <textarea name="address" rows="2" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500"></textarea>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Golongan Darah</label>
                                <select name="blood_type" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500">
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
                    <div class="mt-10 pt-6 border-t border-slate-100 dark:border-slate-700">
                        <label class="block text-sm font-bold text-red-600 dark:text-red-400 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Riwayat Alergi Obat & Catatan Medis Khusus
                        </label>
                        <textarea name="allergies" rows="2" 
                            class="w-full rounded-xl border-red-200 dark:border-red-900/30 bg-red-50 dark:bg-red-900/10 dark:text-red-200 focus:border-red-500 focus:ring-red-500 placeholder-red-300 dark:placeholder-red-800" 
                            placeholder="Contoh: Alergi Amoxicillin, Riwayat Asma..."></textarea>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-10 flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('master.patients.index') }}" 
                            class="inline-flex justify-center items-center px-6 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-100 dark:hover:bg-slate-700 transition duration-200">
                            Batal
                        </a>
                        <button type="submit" 
                            class="inline-flex justify-center items-center px-8 py-2.5 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 shadow-lg shadow-blue-500/30 dark:shadow-none transition duration-200 transform hover:-translate-y-0.5">
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