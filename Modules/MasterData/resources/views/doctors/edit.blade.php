<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">
                    {{ __('Edit Data Dokter') }}
                </h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">Pembaruan data profesional dan status operasional tenaga medis</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                <span class="hover:text-neutral-900 dark:hover:text-neutral-50 cursor-pointer transition-colors"><a href="{{ route('master.doctors.index') }}">Dokter</a></span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Edit Profil</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-50 p-6 sm:p-8">
                
               <h3 class="text-xs font-semibold uppercase tracking-widest text-neutral-500 dark:text-neutral-400 mb-6 flex items-center">
                    <span class="bg-neutral-900 dark:bg-neutral-50 w-1 h-4 rounded-full mr-3"></span>
                    Perbarui Informasi Dokter
                </h3>

                <form action="{{ route('master.doctors.update', $doctor->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        
                        {{-- ID Dokter (Read Only) --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-neutral-500">ID Dokter (Sistem)</label>
                            <input type="text" value="{{ $doctor->code }}" disabled 
                                class="flex h-9 w-full rounded-md border border-neutral-200 bg-neutral-100 px-3 py-1 text-sm shadow-sm transition-colors dark:border-neutral-800 dark:bg-neutral-800 dark:text-neutral-400 font-mono cursor-not-allowed">
                        </div>

                        {{-- Nama --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nama Lengkap & Gelar <span class="text-destructive">*</span></label>
                            <input type="text" name="name" value="{{ $doctor->name }}"
                                class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300" required>
                        </div>

                        {{-- NIK --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">NIK / Nomor KTP <span class="text-destructive">*</span></label>
                            <input type="text" name="nik_ktp" value="{{ $doctor->nik_ktp }}"
                                class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300" required>
                        </div>

                        {{-- SIP --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nomor SIP</label>
                            <input type="text" name="sip" value="{{ $doctor->sip }}"
                                class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                        </div>

                        {{-- Spesialisasi --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Spesialisasi</label>
                            <select name="specialization" 
                                class="flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-neutral-500 focus:outline-none focus:ring-1 focus:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:ring-offset-neutral-950 dark:placeholder:text-neutral-400 dark:focus:ring-neutral-300">
                                @foreach(['Umum', 'Gigi', 'Penyakit Dalam', 'Anak', 'Kandungan', 'Bedah'] as $spec)
                                    <option value="{{ $spec }}" {{ $doctor->specialization == $spec ? 'selected' : '' }}>{{ $spec }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Phone --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nomor Telepon / WhatsApp</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-neutral-500 text-sm font-medium">+62</span>
                                </div>
                                <input type="text" name="phone" value="{{ $doctor->phone }}"
                                    class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 pl-11 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                            </div>
                        </div>

                        {{-- Status Switch --}}
                        <div class="md:col-span-2 mt-4 p-5 bg-neutral-50 dark:bg-neutral-900 rounded-md border border-neutral-200 dark:border-neutral-800 flex items-center justify-between">
                            <div class="pr-4">
                                <span class="block text-sm font-medium leading-none">Status Praktik Aktif</span>
                                <span class="text-xs text-neutral-500 dark:text-neutral-400">Matikan switch ini jika dokter sedang tidak melayani praktik (cuti/tidak aktif) untuk menyembunyikannya dari antrean.</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                                <input type="checkbox" name="is_active" class="sr-only peer" {{ $doctor->is_active ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-neutral-200 dark:bg-neutral-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-neutral-950 dark:peer-focus:ring-neutral-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 dark:after:border-neutral-500 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-neutral-900 dark:peer-checked:bg-neutral-50"></div>
                            </label>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-8 pt-6 border-t border-neutral-200 dark:border-neutral-800 flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('master.doctors.index') }}" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-800 dark:bg-neutral-950 dark:hover:bg-neutral-800 dark:hover:text-neutral-50">
                            Batal
                        </a>
                        <button type="submit" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-4 py-2 dark:bg-neutral-50 dark:text-neutral-900 dark:hover:bg-neutral-50/90">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Perbarui Data
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>