<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">
                    {{ __('Edit Data Pasien') }}
                </h2>
                <p class="text-sm text-neutral-500 mt-1 dark:text-neutral-400">Pembaruan informasi rekam medis dan biodata pasien</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-neutral-500 mt-2 md:mt-0 dark:text-neutral-400">
                <span class="hover:text-neutral-900 dark:hover:text-neutral-50 cursor-pointer transition-colors"><a href="{{ route('master.patients.index') }}">Pasien</a></span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Edit Data</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-50 overflow-hidden p-8">
                
                <h3 class="text-xs font-semibold uppercase tracking-widest text-neutral-500 dark:text-neutral-400 mb-6 flex items-center">
                    <span class="bg-neutral-900 dark:bg-neutral-50 w-1 h-4 rounded-full mr-3"></span>
                    Perbarui Data Pasien
                </h3>

                <form action="{{ route('master.patients.update', $patient->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        
                        {{-- Read Only Info --}}
                        <div class="md:col-span-2 flex flex-col sm:flex-row gap-4">
                            <div class="flex-1 space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">ID Pasien (Sistem)</label>
                                <input type="text" value="{{ $patient->code }}" disabled 
                                    class="flex h-9 w-full rounded-md border border-neutral-200 bg-neutral-100 px-3 py-1 text-sm shadow-sm transition-colors dark:border-neutral-800 dark:bg-neutral-800 dark:text-neutral-400 font-mono cursor-not-allowed">
                            </div>
                            <div class="flex-1 space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Kategori Registrasi</label>
                                <div class="flex h-9 w-full rounded-md border border-neutral-200 bg-neutral-100 px-3 py-1 text-sm shadow-sm dark:border-neutral-800 dark:bg-neutral-800 dark:text-neutral-400 font-medium flex items-center">
                                    <span class="w-2 h-2 rounded-full mr-2 {{ $patient->type == 'karyawan' ? 'bg-blue-500' : 'bg-emerald-500' }}"></span>
                                    {{ ucfirst($patient->type) }}
                                </div>
                            </div>
                        </div>

                        {{-- Nama --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nama Lengkap <span class="text-destructive">*</span></label>
                            <input type="text" name="name" value="{{ $patient->name }}"
                                class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300" required>
                        </div>
                        
                        {{-- NIK (Jika Karyawan) --}}
                        @if ($patient->type == 'karyawan')
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">NIK Perusahaan</label>
                            <input type="text" name="nik" value="{{ $patient->nik }}"
                                class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                        </div>
                        @endif

                        {{-- NIK KTP --}}
                        <div class="space-y-2 {{ $patient->type != 'karyawan' ? 'md:col-span-2' : '' }}">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nomor KTP (NIK)</label>
                            <input type="text" name="ktp" value="{{ $patient->ktp }}"
                                class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                        </div>

                        {{-- Departemen (Jika Karyawan) --}}
                        @if ($patient->type == 'karyawan')
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Bagian / Departemen</label>
                            <input type="text" name="subbag_dept" value="{{ $patient->subbag_dept }}"
                                class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                        </div>
                        @endif

                        {{-- Tanggal Lahir --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Tanggal Lahir</label>
                            <input type="date" name="birth_date" value="{{ $patient->birth_date }}"
                                class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                        </div>

                        {{-- Gender --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Jenis Kelamin</label>
                            <select name="gender" class="flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-neutral-500 focus:outline-none focus:ring-1 focus:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:ring-offset-neutral-950 dark:placeholder:text-neutral-400 dark:focus:ring-neutral-300">
                                <option value="L" {{ $patient->gender == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ $patient->gender == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        {{-- Phone --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">No. Telepon / WhatsApp</label>
                            <input type="text" name="phone" value="{{ $patient->phone }}"
                                class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                        </div>

                        {{-- Blood Type --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Golongan Darah</label>
                            <select name="blood_type" class="flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-neutral-500 focus:outline-none focus:ring-1 focus:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:ring-offset-neutral-950 dark:placeholder:text-neutral-400 dark:focus:ring-neutral-300">
                                @foreach(['','A','B','AB','O'] as $gol)
                                <option value="{{ $gol }}" {{ $patient->blood_type == $gol ? 'selected' : '' }}>{{ $gol ?: '- Pilih -' }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Alamat --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Alamat Domisili</label>
                            <textarea name="alamat" rows="2"
                                class="flex min-h-[80px] w-full rounded-md border border-neutral-200 bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">{{ $patient->alamat }}</textarea>
                        </div>

                        {{-- Alergi Section --}}
                        <div class="md:col-span-2 mt-4 space-y-2">
                            <label class="text-sm font-medium text-destructive flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Riwayat Alergi Obat & Catatan Khusus
                            </label>
                            <textarea name="allergies" rows="2" 
                                class="flex min-h-[80px] w-full rounded-md border border-destructive/20 bg-destructive/5 px-3 py-2 text-sm shadow-sm placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300" 
                                placeholder="Tuliskan riwayat alergi jika ada...">{{ $patient->allergies }}</textarea>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-8 pt-6 border-t border-neutral-200 dark:border-neutral-800 flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('master.patients.index') }}" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-800 dark:bg-neutral-950 dark:hover:bg-neutral-800 dark:hover:text-neutral-50">
                            Batal
                        </a>
                        <button type="submit" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-4 py-2 dark:bg-neutral-50 dark:text-neutral-900 dark:hover:bg-neutral-50/90">
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
