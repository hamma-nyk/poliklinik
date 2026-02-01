<div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" 
     class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-slate-900 md:translate-x-0 md:static md:inset-0 flex flex-col justify-between">

    <div>
        <div class="flex items-center justify-center h-16 bg-slate-950 border-b border-slate-800 shadow-md">
            <span class="text-xl font-bold tracking-wider text-white uppercase">
                POLIKLINIK
            </span>
            <button @click="sidebarOpen = false" class="md:hidden ml-4 text-slate-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <nav class="mt-5 px-4 space-y-2">
            
            @can('view_dashboard')
            <a href="{{ route('dashboard') }}" 
               class="flex items-center px-4 py-3 transition-colors duration-200 rounded-lg group {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="font-medium">Dashboard</span>
            </a>
            @endcan

            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Modul Master</p>
            </div>

            @can('view_master_data')
           <a href="{{ route('master.employees.index') }}" class="flex items-center px-4 py-3 transition-colors duration-200 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white {{ request()->routeIs('master.employees.*') ? 'bg-slate-800 text-white' : '' }}">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        <span class="font-medium">Data Karyawan (HR)</span>
    </a>
             <a href="{{ route('master.doctors.index') }}" 
                   class="flex items-center px-4 py-3 transition-colors duration-200 rounded-lg group {{ request()->routeIs('master.doctors.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    <span class="font-medium">Data Dokter</span>
                </a>

                <a href="{{ route('master.nurses.index') }}" class="flex items-center px-4 py-3 transition-colors duration-200 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white {{ request()->routeIs('master.nurses.*') ? 'bg-slate-800 text-white' : '' }}">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        <span class="font-medium">Data Perawat</span>
    </a>
    <a href="{{ route('master.patients.index') }}" class="flex items-center px-4 py-3 transition-colors duration-200 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white {{ request()->routeIs('master.patients.*') ? 'bg-slate-800 text-white' : '' }}">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="font-medium">Data Pasien</span>
    </a>
            @endcan
 @can('view_master_medicine')
                <a href="{{ route('inventory.medicines.index') }}" 
                   class="flex items-center px-4 py-3 transition-colors duration-200 rounded-lg group {{ request()->routeIs('inventory.medicines.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    <span class="font-medium">Data Obat</span>
                </a>
            @endcan
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Modul Aplikasi</p>
            </div>

           

            @can('view_medicine_history')
                <a href="{{ route('inventory.transactions.index') }}" 
                   class="flex items-center px-4 py-3 transition-colors duration-200 rounded-lg group {{ request()->routeIs('inventory.transactions.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    <span class="font-medium">Riwayat Stok Obat</span>
                </a>
            @endcan

            @can('view_clinical')
            <a href="{{ route('clinical.records.index') }}" class="flex items-center px-4 py-3 transition-colors duration-200 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white {{ request()->routeIs('clinical.records.*') ? 'bg-slate-800 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="font-medium">Rekam Medis</span>
            </a>
            <a href="{{ route('clinical.lab.index') }}" class="flex items-center px-4 py-3 transition-colors duration-200 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white {{ request()->routeIs('clinical.lab.*') ? 'bg-slate-800 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="font-medium">Cek Lab</span>
            </a>
            @endcan
<div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Laporan</p>
            </div>
            @can('laporan')
                <a href="{{ route('clinical.reports.index') }}" 
                   class="flex items-center px-4 py-3 transition-colors duration-200 rounded-lg group {{ request()->routeIs('clinical.reports.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    <span class="font-medium">Laporan Poliklinik</span>
                </a>
            @endcan
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pengaturan</p>
            </div>

            @can('manage_users')
            <a href="{{ route('users.index') }}" class="flex items-center px-4 py-3 transition-colors duration-200 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white {{ request()->routeIs('users.*') ? 'bg-blue-600 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span class="font-medium">Kelola User</span>
            </a>
            @endcan

            @role('superadmin')
            <a href="{{ route('permissions.index') }}" class="flex items-center px-4 py-3 transition-colors duration-200 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white {{ request()->routeIs('permissions.*') ? 'bg-blue-600 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <span class="font-medium">Hak Akses</span>
            </a>
            @endrole
        </nav>
    </div>

    <div class="p-4 border-t border-slate-800 bg-slate-950">    
        
        <div x-data="{ userOpen: false }" class="relative">
            <button @click="userOpen = !userOpen" class="flex items-center w-full focus:outline-none group">
                <div class="flex-shrink-0 w-10 h-10 bg-slate-700 rounded-full flex items-center justify-center text-white font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="ml-3 text-left">
                    <p class="text-sm font-medium text-white group-hover:text-blue-400">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-500">View Profile</p>
                </div>
                <svg class="ml-auto w-4 h-4 text-slate-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div x-show="userOpen" 
                 x-cloak 
                 @click.away="userOpen = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90"
                 class="absolute bottom-14 left-0 w-full bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50 origin-bottom">
                
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile Saya</a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); this.closest('form').submit();" 
                       class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                        Log Out
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

<div x-show="sidebarOpen" 
     @click="sidebarOpen = false" 
     class="fixed inset-0 z-20 bg-black opacity-50 md:hidden"></div>