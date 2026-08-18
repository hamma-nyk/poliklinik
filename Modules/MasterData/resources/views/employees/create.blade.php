<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">
                    {{ __('Tambah Karyawan Manual') }}
                </h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">Pendaftaran karyawan baru ke dalam sistem database</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                <span class="hover:text-neutral-900 dark:hover:text-neutral-50 cursor-pointer transition-colors"><a href="{{ route('master.employees.index') }}">Karyawan</a></span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Tambah Data</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-6 sm:p-8">
                
                <h3 class="text-xs font-semibold uppercase tracking-widest text-neutral-500 dark:text-neutral-400 mb-6 flex items-center">
                    <span class="bg-neutral-900 dark:bg-neutral-50 w-1 h-4 rounded-full mr-3"></span>
                    Informasi Biodata Karyawan
                </h3>

                <form action="{{ route('master.employees.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        {{-- NIK --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">NIK Perusahaan <span class="text-destructive">*</span></label>
                            <input type="text" name="nik" placeholder="Contoh: 2024001" 
                                class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300" required>
                        </div>

                        {{-- Nama --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nama Lengkap <span class="text-destructive">*</span></label>
                            <input type="text" name="nama" placeholder="Masukkan nama sesuai KTP"
                                class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300" required>
                        </div>

                        {{-- KTP --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">No. KTP</label>
                            <input type="text" name="ktp" placeholder="16 Digit Nomor KTP"
                                class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                        </div>

                        {{-- Phone --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">No. HP / Phone</label>
                            <input type="text" name="phone" placeholder="0899..."
                                class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Tanggal Lahir</label>
                            <input type="date" name="birth_date" 
                                class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                        </div>

                        {{-- 1. Departemen --}}
<div class="space-y-2">
    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Departemen (Bagian)</label>
    <select name="bag_dept" class="tom-select">
        <option value="">-- Pilih Departemen --</option>
        @foreach($departments as $dept)
            <option value="{{ $dept->code }}" {{ old('bag_dept') == $dept->code ? 'selected' : '' }}>
                {{ $dept->code }} - {{ $dept->name }}
            </option>
        @endforeach
    </select>
    @error('bag_dept')
        <p class="text-destructive text-[0.8rem] mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- 2. Bagian (Sub Dept) --}}
<div class="space-y-2">
    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Bagian (Sub Dept)</label>
    <select name="subbag_dept" class="tom-select">
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
    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Sub Bagian (Unit)</label>
    <select name="sub_subbag_dept" class="tom-select">
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
    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Jabatan</label>
    <select name="jabatan" class="tom-select">
        <option value="">-- Pilih Jabatan --</option>
        @foreach($positions as $pos)
            <option value="{{ $pos->code }}" {{ old('jabatan') == $pos->code ? 'selected' : '' }}>
                {{ $pos->code }} - {{ $pos->name }}
            </option>
        @endforeach
    </select>
    @error('jabatan')
        <p class="text-destructive text-[0.8rem] mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- SCRIPT TOM SELECT --}}
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.tom-select').forEach((el) => {
            new TomSelect(el, {
                create: false,
                sortField: { field: "text", order: "asc" }
            });
        });
    });
</script>
@endpush

{{-- STYLE AGAR MIRIP INPUT BAWAAN --}}
@push('styles')
<style>
    /* TomSelect Dark Mode Styling */
    .ts-wrapper.single .ts-control { 
        border-radius: 0.375rem !important; 
        padding: 0.25rem 0.75rem !important; 
        height: 36px !important;
        border-color: #e2e8f0 !important; 
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05) !important;
        font-size: 0.875rem !important;
        display: flex;
        align-items: center;
        background-color: transparent !important;
    }
    .dark .ts-wrapper.single .ts-control { 
        border-color: #1e293b !important; 
        color: #f8fafc !important; 
    }
    .ts-wrapper.single .ts-control input {
        font-size: 0.875rem !important;
    }
    .dark .ts-wrapper.single .ts-control input {
        color: #f8fafc !important;
    }
    .ts-dropdown { 
        border-radius: 0.375rem !important;
        border-color: #e2e8f0 !important;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1) !important;
        font-size: 0.875rem !important;
        z-index: 50 !important;
    }
    .dark .ts-dropdown { 
        background-color: #020617 !important; 
        border-color: #1e293b !important; 
        color: #f8fafc !important; 
    }
    .ts-dropdown .option {
        padding: 8px 12px !important;
    }
    .ts-dropdown .active { 
        background-color: #f1f5f9 !important; 
        color: #0f172a !important; 
    }
    .dark .ts-dropdown .active { 
        background-color: #1e293b !important; 
        color: #f8fafc !important; 
    }
    .dark .ts-dropdown .option { 
        color: #cbd5e1; 
    }
</style>
@endpush

                        {{-- Gender --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Jenis Kelamin</label>
                            <select name="gender" class="flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-neutral-500 focus:outline-none focus:ring-1 focus:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:ring-offset-neutral-950 dark:placeholder:text-neutral-400 dark:focus:ring-neutral-300">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        {{-- Blood Type --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Golongan Darah</label>
                            <select name="blood" class="flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-neutral-500 focus:outline-none focus:ring-1 focus:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:ring-offset-neutral-950 dark:placeholder:text-neutral-400 dark:focus:ring-neutral-300">
                                <option value="">- Pilih Golongan Darah -</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>

                        {{-- Alamat --}}
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Alamat</label>
                            <textarea class="flex min-h-[80px] w-full rounded-md border border-neutral-200 bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300" name="address" placeholder="Contoh: Jl. Kebon Jeruk No. 10, Jakarta Selatan"></textarea>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-neutral-200 dark:border-neutral-600 flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('master.employees.index') }}" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50">
                            Batal
                        </a>
                        <button type="submit" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-4 py-2 dark:bg-neutral-50 dark:text-neutral-900 dark:hover:bg-neutral-50/90">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Data
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>