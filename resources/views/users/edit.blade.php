<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Edit Pengguna') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Akun: <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ $user->name }}</span></p>
            </div>
            <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- Section 1: Profil Dasar --}}
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                            <h3 class="text-sm font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-6 flex items-center">
                                <span class="w-2 h-2 bg-amber-500 rounded-full mr-3"></span>
                                1. Informasi Akun
                            </h3>
                            
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-2">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                        class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-amber-500 focus:ring-amber-500 transition-all text-sm" required>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-2">Username</label>
                                    <input type="text" name="username" value="{{ old('username', $user->username) }}"
                                        class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-amber-500 focus:ring-amber-500 transition-all text-sm" required>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-2">Alamat Email</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                        class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-amber-500 focus:ring-amber-500 transition-all text-sm" required>
                                </div>

                                <div class="pt-4 border-t border-slate-100 dark:border-slate-700">
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-2">Ganti Password</label>
                                    <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" 
                                        class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-amber-500 focus:ring-amber-500 transition-all text-sm">
                                    <p class="text-[10px] text-slate-400 mt-2 italic">*Hanya isi jika Anda ingin memperbarui keamanan akun ini.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Otoritas --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                            <h3 class="text-sm font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-6 flex items-center">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full mr-3"></span>
                                2. Penyesuaian Hak Akses
                            </h3>
                            
                            <p class="text-xs text-slate-500 dark:text-slate-400 mb-6 italic">Centang modul yang dapat dikelola oleh pengguna ini:</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($permissions as $permission)
                                    <label class="relative group flex items-center p-4 border border-slate-100 dark:border-slate-700 rounded-xl hover:bg-amber-50 dark:hover:bg-amber-900/10 hover:border-amber-300 dark:hover:border-amber-500 transition-all cursor-pointer">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                                class="h-5 w-5 rounded border-slate-300 dark:border-slate-600 text-amber-600 focus:ring-amber-500 dark:bg-slate-700"
                                                {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }}>
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

                        {{-- Action Buttons --}}
                        <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-4">
                            <a href="{{ route('users.index') }}" class="text-sm font-bold text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">Batalkan Perubahan</a>
                            <button type="submit" class="w-full sm:w-auto bg-slate-900 dark:bg-amber-600 text-white px-12 py-4 rounded-2xl font-black hover:bg-indigo-700 dark:hover:bg-amber-500 shadow-xl shadow-slate-200 dark:shadow-none transition-all transform hover:-translate-y-1 uppercase tracking-widest text-sm">
                                Simpan Pembaruan
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>