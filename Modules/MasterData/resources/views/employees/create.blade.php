<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Tambah Karyawan Manual') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Pendaftaran karyawan baru ke dalam sistem database</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-slate-500 mt-2 md:mt-0 dark:text-slate-400">
                <span class="hover:text-blue-600 cursor-pointer transition-colors">Karyawan</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Tambah Data</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700 p-8">
                
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-6 flex items-center">
                    <span class="w-1.5 h-6 bg-blue-600 rounded-full mr-3"></span>
                    Informasi Biodata
                </h3>

                <form action="{{ route('master.employees.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        {{-- NIK --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">NIK Perusahaan <span class="text-red-500">*</span></label>
                            <input type="text" name="nik" placeholder="Contoh: 2024001" 
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all" required>
                        </div>

                        {{-- Nama --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" placeholder="Masukkan nama sesuai KTP"
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all" required>
                        </div>

                        {{-- KTP --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">No. KTP</label>
                            <input type="text" name="ktp" placeholder="16 Digit Nomor KTP"
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all">
                        </div>

                        {{-- KTP --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">No. HP / Phone</label>
                            <input type="text" name="phone" placeholder="0899..."
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all">
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Tanggal Lahir</label>
                            <input type="date" name="birth_date" 
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all">
                        </div>

                        {{-- 1. Departemen --}}
<div class="space-y-2">
    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Departemen (Bagian)</label>
    <select name="bag_dept" class="select2 w-full">
        <option value="">-- Pilih Departemen --</option>
        @foreach($departments as $dept)
            <option value="{{ $dept->code }}" {{ old('bag_dept') == $dept->code ? 'selected' : '' }}>
                {{ $dept->code }} - {{ $dept->name }}
            </option>
        @endforeach
    </select>
    @error('bag_dept')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- 2. Bagian (Sub Dept) --}}
<div class="space-y-2">
    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Bagian (Sub Dept)</label>
    <select name="subbag_dept" class="select2 w-full">
        <option value="">-- Pilih Bagian --</option>
        @foreach($subDepartments as $sub)
            <option value="{{ $sub->code }}" {{ old('subbag_dept') == $sub->code ? 'selected' : '' }}>
                {{ $sub->code }} - {{ $sub->name }}
            </option>
        @endforeach
    </select>
</div>

{{-- 3. Sub Bagian (Unit) --}}
<div class="space-y-2">
    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Sub Bagian (Unit)</label>
    <select name="sub_subbag_dept" class="select2 w-full">
        <option value="">-- Pilih Unit --</option>
        @foreach($units as $unit)
            <option value="{{ $unit->code }}" {{ old('sub_subbag_dept') == $unit->code ? 'selected' : '' }}>
                {{ $unit->code }} - {{ $unit->name }}
            </option>
        @endforeach
    </select>
</div>

{{-- 4. Jabatan --}}
<div class="space-y-2">
    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Jabatan</label>
    <select name="jabatan" class="select2 w-full">
        <option value="">-- Pilih Jabatan --</option>
        @foreach($positions as $pos)
            <option value="{{ $pos->code }}" {{ old('jabatan') == $pos->code ? 'selected' : '' }}>
                {{ $pos->code }} - {{ $pos->name }}
            </option>
        @endforeach
    </select>
    @error('jabatan')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- SCRIPT SELECT2 --}}
@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%', 
            placeholder: "Ketik untuk mencari...",
            allowClear: true
        });
    });
</script>
@endpush

{{-- STYLE AGAR MIRIP INPUT BAWAAN (Opsional, taruh di layout utama lebih baik) --}}
@push('styles')
<style>
    .select2-container .select2-selection--single {
        height: 42px !important;
        border-color: #e2e8f0 !important; /* slate-200 */
        border-radius: 0.75rem !important; /* rounded-xl */
        display: flex;
        align-items: center;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 8px !important;
    }
</style>
@endpush

                        {{-- Gender --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Jenis Kelamin</label>
                            <select name="gender" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        {{-- Blood Type --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Golongan Darah</label>
                            <select name="blood" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all">
                                <option value="">- Pilih Golongan Darah -</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>

                        {{-- Alamat --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Alamat</label>
                            <textarea class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all" name="address" placeholder="Contoh: Jl. Kebon Jeruk No. 10, Jakarta Selatan"></textarea>
                        </div>
                    </div>

                    <div class="mt-10 pt-6 border-t border-slate-100 dark:border-slate-700 flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('master.employees.index') }}" 
                            class="inline-flex justify-center items-center px-6 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-100 dark:hover:bg-slate-700 transition duration-200">
                            Batal
                        </a>
                        <button type="submit" 
                            class="inline-flex justify-center items-center px-8 py-2.5 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 shadow-lg shadow-blue-500/30 dark:shadow-none transition duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Data Karyawan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>