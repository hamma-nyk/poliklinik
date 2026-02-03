<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Edit Perawat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200 p-8"
                 x-data="{ 
                    type: '{{ old('type', $nurse->type) }}',
                 }">
                
                <form action="{{ route('master.nurses.update', $nurse->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Status Kepegawaian</label>
                        <div class="flex gap-4">
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-slate-50 w-full transition" 
                                   :class="type == 'karyawan' ? 'border-blue-500 bg-blue-50 ring-1 ring-blue-500' : 'border-slate-300'">
                                <input type="radio" name="type" value="karyawan" x-model="type" class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 font-bold text-slate-700">Internal (Karyawan)</span>
                            </label>
                            
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-slate-50 w-full transition"
                                   :class="type == 'eksternal' ? 'border-blue-500 bg-blue-50 ring-1 ring-blue-500' : 'border-slate-300'">
                                <input type="radio" name="type" value="eksternal" x-model="type" class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 font-bold text-slate-700">Eksternal (Mitra/Luar)</span>
                            </label>
                        </div>
                    </div>

                    <div x-show="type == 'karyawan'" class="mb-6 bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <label class="block font-bold text-blue-800 mb-2">Link Data Karyawan</label>
                        <select id="employee_selector" name="employee_id" class="w-full rounded-lg border-blue-300 focus:border-blue-500 focus:ring-blue-500">
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
                        <p class="text-xs text-blue-600 mt-2">*Mengubah karyawan akan menimpa data Nama, NIK, dan HP di bawah.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">ID System (Read Only)</label>
                            <input type="text" value="{{ $nurse->code }}" disabled class="w-full bg-slate-100 text-slate-500 rounded-lg border-slate-200 font-mono">
                        </div>

                        <div x-show="type == 'karyawan'">
                            <label class="block text-sm font-bold text-slate-700 mb-2">NIK Perusahaan</label>
                            <input type="text" name="nik" id="nik" value="{{ old('nik', $nurse->nik) }}" class="w-full rounded-lg border-slate-300 bg-slate-100" readonly>
                        </div>

                        <div :class="type == 'eksternal' ? 'col-span-2' : ''">
                            <label class="block text-sm font-bold text-slate-700 mb-2">NIK (KTP)</label>
                            <input type="text" name="ktp" id="ktp" value="{{ old('ktp', $nurse->ktp) }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $nurse->nama) }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" :readonly="type == 'karyawan'" :class="type == 'karyawan' ? 'bg-slate-100' : ''" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nomor STR</label>
                            <input type="text" name="str" value="{{ old('str', $nurse->str) }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Telepon</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $nurse->phone) }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Domisili</label>
                            <textarea name="alamat" id="alamat" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" rows="3">{{ old('alamat', $nurse->alamat) }}</textarea>
                        </div>

                        <div class="md:col-span-2 mt-4 p-5 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between">
                            <div>
                                <span class="block font-bold text-slate-800">Status Aktif</span>
                                <span class="text-xs text-slate-500">Matikan jika perawat sudah tidak bekerja.</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ $nurse->is_active ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-4">
                        <a href="{{ route('master.nurses.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-bold hover:bg-slate-50 transition">Batal</a>
                        <button type="submit" class="px-6 py-2.5 rounded-lg bg-slate-900 text-white font-bold hover:bg-blue-900 shadow-lg transition transform hover:-translate-y-0.5">Simpan Perubahan</button>
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