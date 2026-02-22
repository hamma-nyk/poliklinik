<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Edit Data Pasien') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Pembaruan informasi rekam medis dan biodata pasien</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-slate-500 mt-2 md:mt-0 dark:text-slate-400">
                <span class="hover:text-blue-600 cursor-pointer transition-colors"><a href="{{ route('master.patients.index') }}">Pasien</a></span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Edit Data</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700 p-8">
                
                <h3 class="text-[10px] font-bold text-slate-400 dark:text-slate-100 uppercase tracking-[0.2em] flex items-center mb-6">
                    <span class="bg-amber-500 w-1.5 h-5 rounded-full mr-3"></span>
                    Perbarui Data Pasien
                </h3>

                <form action="{{ route('master.patients.update', $patient->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        
                        {{-- Read Only Info --}}
                        <div class="md:col-span-2 flex flex-col sm:flex-row gap-4">
                            <div class="flex-1 space-y-2">
                                <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">ID Pasien (Sistem)</label>
                                <input type="text" value="{{ $patient->code }}" disabled 
                                    class="w-full bg-slate-100 dark:bg-slate-700/50 text-slate-500 dark:text-slate-400 rounded-xl border-slate-200 dark:border-slate-600 font-mono cursor-not-allowed">
                            </div>
                            <div class="flex-1 space-y-2">
                                <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Kategori Registrasi</label>
                                <div class="px-4 py-2.5 bg-slate-100 dark:bg-slate-700/50 text-slate-600 dark:text-slate-300 rounded-xl border border-slate-200 dark:border-slate-600 font-bold flex items-center">
                                    <span class="w-2 h-2 rounded-full mr-2 {{ $patient->type == 'karyawan' ? 'bg-blue-500' : 'bg-emerald-500' }}"></span>
                                    {{ ucfirst($patient->type) }}
                                </div>
                            </div>
                        </div>

                        {{-- Nama --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ $patient->name }}"
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all" required>
                        </div>
                        
                        {{-- NIK (Jika Karyawan) --}}
                        @if ($patient->type == 'karyawan')
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">NIK Perusahaan</label>
                            <input type="text" name="nik" value="{{ $patient->nik }}"
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all">
                        </div>
                        @endif

                        {{-- NIK KTP --}}
                        <div class="space-y-2 {{ $patient->type != 'karyawan' ? 'md:col-span-2' : '' }}">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Nomor KTP (NIK)</label>
                            <input type="text" name="ktp" value="{{ $patient->ktp }}"
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all">
                        </div>

                        {{-- Departemen (Jika Karyawan) --}}
                        @if ($patient->type == 'karyawan')
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Bagian / Departemen</label>
                            <input type="text" name="subbag_dept" value="{{ $patient->subbag_dept }}"
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all">
                        </div>
                        @endif

                        {{-- Tanggal Lahir --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Tanggal Lahir</label>
                            <input type="date" name="birth_date" value="{{ $patient->birth_date }}"
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all">
                        </div>

                        {{-- Gender --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Jenis Kelamin</label>
                            <select name="gender" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all">
                                <option value="L" {{ $patient->gender == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ $patient->gender == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        {{-- Phone --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">No. Telepon / WhatsApp</label>
                            <input type="text" name="phone" value="{{ $patient->phone }}"
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all">
                        </div>

                        {{-- Blood Type --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Golongan Darah</label>
                            <select name="blood_type" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all">
                                @foreach(['','A','B','AB','O'] as $gol)
                                <option value="{{ $gol }}" {{ $patient->blood_type == $gol ? 'selected' : '' }}>{{ $gol ?: '- Pilih -' }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Alamat --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Alamat Domisili</label>
                            <textarea name="alamat" rows="2"
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all">{{ $patient->alamat }}</textarea>
                        </div>

                        {{-- Alergi Section --}}
                        <div class="md:col-span-2 mt-4 space-y-2">
                            <label class="block text-sm font-bold text-red-600 dark:text-red-400 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Riwayat Alergi Obat & Catatan Khusus
                            </label>
                            <textarea name="allergies" rows="2" 
                                class="w-full rounded-xl border-red-200 dark:border-red-900/30 bg-red-50 dark:bg-red-900/10 dark:text-red-200 focus:border-red-500 focus:ring-red-500" 
                                placeholder="Tuliskan riwayat alergi jika ada...">{{ $patient->allergies }}</textarea>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-10 pt-6 border-t border-slate-100 dark:border-slate-700 flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('master.patients.index') }}" 
                            class="inline-flex justify-center items-center px-6 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-100 dark:hover:bg-slate-700 transition duration-200">
                            Batal
                        </a>
                        <button type="submit" 
                            class="inline-flex justify-center items-center px-8 py-2.5 rounded-xl bg-slate-900 dark:bg-blue-600 text-white font-bold hover:bg-blue-800 dark:hover:bg-blue-500 shadow-lg dark:shadow-none transition duration-200 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Update Data Pasien
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>