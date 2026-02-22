<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Tambah User Baru') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Manajemen akun pengguna dan konfigurasi hak akses</p>
            </div>
            <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Error Notifications --}}
            @if ($errors->any())
                <div class="bg-rose-50 dark:bg-rose-900/20 border-l-4 border-rose-500 text-rose-800 dark:text-rose-400 p-4 rounded-xl shadow-sm mb-6">
                    <div class="flex">
                        <svg class="h-5 w-5 text-rose-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <ul class="text-sm font-bold">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- Section 1: Profil Akun --}}
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                            <h3 class="text-sm font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-6 flex items-center">
                                <span class="w-2 h-2 bg-indigo-500 rounded-full mr-3"></span>
                                1. Data Profil
                            </h3>
                            
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-2">Nama Lengkap</label>
                                    <input type="text" name="name" placeholder="Masukkan nama..." 
                                        class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 transition-all text-sm" required>
                                </div>

                                {{-- Username (TAMBAHAN BARU) --}}
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-2">Username</label>
                                    <input type="text" name="username" placeholder="Masukkan username..." 
                                        class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 transition-all text-sm" required>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-2">Alamat Email</label>
                                    <input type="email" name="email" placeholder="nama@klinik.com" 
                                        class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 transition-all text-sm" required>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-2">Password Akun</label>
                                    <input type="password" name="password" placeholder="Minimal 8 karakter..." 
                                        class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 transition-all text-sm" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Hak Akses --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                            <h3 class="text-sm font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-6 flex items-center">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full mr-3"></span>
                                2. Otoritas & Hak Akses Menu
                            </h3>
                            
                            <p class="text-xs text-slate-500 dark:text-slate-400 mb-6 italic">Pilih modul yang diizinkan untuk diakses oleh user ini:</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($permissions as $permission)
                                    <label class="relative group flex items-center p-4 border border-slate-100 dark:border-slate-700 rounded-xl hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:border-indigo-300 dark:hover:border-indigo-500 transition-all cursor-pointer">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                                class="h-5 w-5 rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500 dark:bg-slate-700">
                                        </div>
                                        <div class="ml-4">
                                            <span class="block text-xs font-black text-slate-700 dark:text-slate-200 uppercase tracking-tighter">
                                                {{ str_replace('_', ' ', $permission->name) }}
                                            </span>
                                            <span class="block text-[10px] text-slate-400 dark:text-slate-500">Izin akses modul {{ strtolower(str_replace('_', ' ', $permission->name)) }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Action Button --}}
                        <div class="flex justify-end pt-4">
                            <button type="submit" class="w-full md:w-auto bg-slate-900 dark:bg-indigo-600 text-white px-12 py-4 rounded-2xl font-black hover:bg-indigo-700 dark:hover:bg-indigo-500 shadow-xl shadow-indigo-500/20 transform hover:-translate-y-1 transition-all uppercase tracking-widest text-sm">
                                Daftarkan User Baru
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>