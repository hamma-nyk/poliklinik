<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">
                    {{ __('Edit Data Perawat ') }}
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Pembaruan informasi profil dan status kepegawaian</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-slate-500 dark:text-slate-400">
                <span class="hover:text-slate-900 dark:hover:text-slate-50 cursor-pointer transition-colors"><a href="{{ route('master.nurses.index') }}">Perawat</a></span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-900 dark:text-slate-50">Edit Data</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 p-6 sm:p-8"
                 x-data="{ 
                    type: '{{ old('type', $nurse->type) }}',
                 }">
                <h3 class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-6 flex items-center">
                    <span class="bg-slate-900 dark:bg-slate-50 w-1 h-4 rounded-full mr-3"></span>
                    Perbarui Informasi Perawat
                </h3>
                <form action="{{ route('master.nurses.update', $nurse->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-6">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-3 block">Status Kepegawaian</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <label class="flex items-center p-4 border rounded-md cursor-pointer transition-all duration-200" 
                                   :class="type == 'karyawan' ? 'border-slate-900 bg-slate-100 dark:border-slate-50 dark:bg-slate-800' : 'border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-900/50'">
                                <input type="radio" name="type" value="karyawan" x-model="type" class="w-4 h-4 text-slate-900 focus:ring-slate-950 border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:checked:bg-slate-50 dark:focus:ring-slate-300">
                                <span class="ml-3 block text-sm font-medium leading-none">Internal (Karyawan)</span>
                            </label>
                            
                            <label class="flex items-center p-4 border rounded-md cursor-pointer transition-all duration-200"
                                   :class="type == 'eksternal' ? 'border-slate-900 bg-slate-100 dark:border-slate-50 dark:bg-slate-800' : 'border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-900/50'">
                                <input type="radio" name="type" value="eksternal" x-model="type" class="w-4 h-4 text-slate-900 focus:ring-slate-950 border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:checked:bg-slate-50 dark:focus:ring-slate-300">
                                <span class="ml-3 block text-sm font-medium leading-none">Eksternal (Mitra/Luar)</span>
                            </label>
                        </div>
                    </div>

                    <div x-show="type == 'karyawan'" class="mb-6 rounded-md border border-sky-200 bg-sky-50 px-4 py-3 text-sm text-sky-900 shadow-sm dark:border-sky-800 dark:bg-sky-950 dark:text-sky-200 p-6">
                        <label class="block text-xs font-semibold uppercase tracking-widest text-sky-800 dark:text-sky-400 mb-3 ml-1">Link Data Karyawan</label>
                        <select id="employee_selector" name="employee_id" class="flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-sky-200 bg-white dark:bg-slate-950 px-3 py-1 text-sm shadow-sm ring-offset-white focus:outline-none focus:ring-1 focus:ring-slate-950 dark:border-sky-800 dark:ring-offset-slate-950">
                            <option value="">-- Pilih Karyawan (Untuk Update Data) --</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" 
                                    {{ $nurse->employee_id == $emp->id ? 'selected' : '' }}
                                    data-nik="{{ $emp->nik }}"
                                    data-nama="{{ $emp->nama }}"
                                    data-ktp="{{ $emp->ktp ?? '' }}"
                                    data-phone="{{ $emp->phone }}"
                                    data-alamat="{{ $emp->alamat }}">
                                    {{ $emp->nik }} - {{ $emp->nama }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-sky-700 dark:text-sky-300 mt-2">*Mengubah karyawan akan menimpa data Nama, NIK, dan HP di bawah.</p>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            <div class="md:col-span-2 space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-slate-500">ID System (Read Only)</label>
                                <input type="text" value="{{ $nurse->code }}" disabled class="flex h-9 w-full rounded-md border border-slate-200 bg-slate-100 px-3 py-1 text-sm shadow-sm transition-colors dark:border-slate-800 dark:bg-slate-800 dark:text-slate-400 font-mono cursor-not-allowed">
                            </div>

                            <div x-show="type == 'karyawan'" class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">NIK Perusahaan</label>
                                <input type="text" name="nik" id="nik" value="{{ old('nik', $nurse->nik) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-slate-100 px-3 py-1 text-sm shadow-sm transition-colors dark:border-slate-800 dark:bg-slate-800 dark:text-slate-400 font-mono" readonly>
                            </div>

                            <div :class="type == 'eksternal' ? 'col-span-2 space-y-2' : 'space-y-2'">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">KTP</label>
                                <input type="text" name="ktp" id="ktp" value="{{ old('ktp', $nurse->ktp) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $nurse->nama) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300" :readonly="type == 'karyawan'" :class="type == 'karyawan' ? 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400' : ''" required>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nomor STR</label>
                            <input type="text" name="str" value="{{ old('str', $nurse->str) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nomor Telepon</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $nurse->phone) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Alamat Domisili</label>
                            <textarea name="alamat" id="alamat" class="flex min-h-[80px] w-full rounded-md border border-slate-200 bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300" rows="3">{{ old('alamat', $nurse->alamat) }}</textarea>
                        </div>

                        <div class="mt-4 p-5 bg-slate-50 dark:bg-slate-900 rounded-md border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                            <div class="pr-4">
                                <span class="block text-sm font-medium leading-none">Status Aktif</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400">Matikan jika perawat sudah tidak bekerja.</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ $nurse->is_active ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-slate-200 dark:bg-slate-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-slate-950 dark:peer-focus:ring-slate-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 dark:after:border-slate-500 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-slate-900 dark:peer-checked:bg-slate-50"></div>
                            </label>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('master.nurses.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 border border-slate-200 bg-white shadow-sm hover:bg-slate-100 hover:text-slate-900 h-9 px-4 py-2 dark:border-slate-800 dark:bg-slate-950 dark:hover:bg-slate-800 dark:hover:text-slate-50">Batal</a>
                        <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 bg-slate-900 text-slate-50 shadow hover:bg-slate-900/90 h-9 px-4 py-2 dark:bg-slate-50 dark:text-slate-900 dark:hover:bg-slate-50/90">Simpan Perubahan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.getElementById('employee_selector').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            
            if (this.value) {
                // Ambil data dari attribute data-*
                var nik = selectedOption.getAttribute('data-nik');
                var nama = selectedOption.getAttribute('data-nama');
                var ktp = selectedOption.getAttribute('data-ktp');
                var phone = selectedOption.getAttribute('data-phone');
                var alamat = selectedOption.getAttribute('data-alamat');

                // Isi ke kolom input
                document.getElementById('nik').value = nik;
                document.getElementById('nama').value = nama;
                // Hanya update jika data employee punya KTP, jika kosong biarkan yang lama
                if(ktp) document.getElementById('ktp').value = ktp;
                if(phone) document.getElementById('phone').value = phone;
                if(alamat) document.getElementById('alamat').value = alamat;
            }
        });
    </script>
</x-app-layout>