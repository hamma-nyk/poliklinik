<div x-show="sidebarOpen" 
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="sidebarOpen = false" 
     class="fixed inset-0 z-20 bg-slate-900/80 backdrop-blur-sm md:hidden"></div>

<div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
     class="fixed inset-y-0 left-0 z-30 w-72 bg-slate-900 text-white transition-all duration-300 ease-in-out md:translate-x-0 md:static md:inset-0 flex flex-col border-r border-slate-200 dark:border-slate-800 shadow-2xl" >

    <div class="flex items-center justify-between h-22 px-6 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 transition-colors duration-300">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
            <div class="relative flex items-center justify-center w-10 h-10 bg-blue-600 rounded-lg shadow-lg shadow-blue-500/30 group-hover:scale-105 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="text-lg font-bold tracking-wide text-slate-800 dark:text-slate-100 ">POLIKLINIK</span>
                <span class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold">PT NUSANTARA BUILDING INDUSTRIES</span>
            </div>
        </a>
        
        <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto custom-scrollbar bg-white dark:bg-slate-900 transition-colors duration-300">
        
        @can('view_dashboard')
        
        <a href="{{ route('dashboard') }}" 
           class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('dashboard') ? 'bg-blue-600/10 text-blue-400' : 'text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-500 dark:hover:text-slate-100' }}">
            
            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-blue-500 rounded-r-full transition-opacity duration-200 {{ request()->routeIs('dashboard') ? 'opacity-100' : 'opacity-0' }}"></span>

            <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('dashboard') ? 'text-blue-400' : 'text-slate-400 dark:text-slate-400 dark:group-hover:text-slate-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            <span class="font-medium text-sm">Dashboard</span>
        </a>
        @endcan

        <div class="pt-6 pb-2 px-4">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Master Data</p>
        </div>

        @can('view_master_data')
            <a href="{{ route('master.employees.index') }}" 
               class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('master.employees.*') ? 'bg-blue-600/10 text-blue-400' : 'text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-500 dark:hover:text-slate-100' }}">
                <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-500 rounded-r-full transition-opacity duration-200 {{ request()->routeIs('master.employees.*') ? 'opacity-100' : 'opacity-0' }}"></span>
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span class="font-medium text-sm">Data Karyawan</span>
            </a>

            <a href="{{ route('master.doctors.index') }}" 
               class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('master.doctors.*') ? 'bg-blue-600/10 text-blue-400' : 'text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-500 dark:hover:text-slate-100' }}">
                <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-500 rounded-r-full transition-opacity duration-200 {{ request()->routeIs('master.doctors.*') ? 'opacity-100' : 'opacity-0' }}"></span>
<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span class="font-medium text-sm">Data Dokter</span>
            </a>

            <a href="{{ route('master.nurses.index') }}" 
               class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('master.nurses.*') ? 'bg-blue-600/10 text-blue-400' : 'text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-500 dark:hover:text-slate-100' }}">
               <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-500 rounded-r-full transition-opacity duration-200 {{ request()->routeIs('master.nurses.*') ? 'opacity-100' : 'opacity-0' }}"></span>
<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
               <span class="font-medium text-sm">Data Perawat</span>
            </a>

            <a href="{{ route('master.patients.index') }}" 
               class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('master.patients.*') ? 'bg-blue-600/10 text-blue-400' : 'text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-500 dark:hover:text-slate-100' }}">
               <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-500 rounded-r-full transition-opacity duration-200 {{ request()->routeIs('master.patients.*') ? 'opacity-100' : 'opacity-0' }}"></span>
<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
               <span class="font-medium text-sm">Data Pasien</span>
            </a>
        @endcan

        @can('view_master_medicine')
            <a href="{{ route('inventory.medicines.index') }}" 
               class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('inventory.medicines.*') ? 'bg-blue-600/10 text-blue-400' : 'text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-500 dark:hover:text-slate-100' }}">
               <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-500 rounded-r-full transition-opacity duration-200 {{ request()->routeIs('inventory.medicines.*') ? 'opacity-100' : 'opacity-0' }}"></span>
<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
            </svg>
            <span class="font-medium text-sm">Data Obat</span>
            </a>
        @endcan

        <div class="pt-6 pb-2 px-4">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Klinis & Transaksi</p>
        </div>

        @can('view_medicine_history')
            <a href="{{ route('inventory.transactions.index') }}" 
               class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('inventory.transactions.*') ? 'bg-blue-600/10 text-blue-400' : 'text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-500 dark:hover:text-slate-100' }}">
               <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-500 rounded-r-full transition-opacity duration-200 {{ request()->routeIs('inventory.transactions.*') ? 'opacity-100' : 'opacity-0' }}"></span>
<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
               <span class="font-medium text-sm">Transaksi Obat</span>
            </a>
        @endcan

        

         @can('adjustment_obat')
            <a href="{{ route('inventory.adjustments.index') }}" 
               class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('inventory.adjustments.*') ? 'bg-blue-600/10 text-blue-400' : 'text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-500 dark:hover:text-slate-100' }}">
               <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-500 rounded-r-full transition-opacity duration-200 {{ request()->routeIs('inventory.adjustments.*') ? 'opacity-100' : 'opacity-0' }}"></span>
<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
               <span class="font-medium text-sm">Adjustment Obat</span>
            </a>
             <a href="{{ route('inventory.reports.stock_card') }}" 
               class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('inventory.reports.*') ? 'bg-blue-600/10 text-blue-400' : 'text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-500 dark:hover:text-slate-100' }}">
               <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-500 rounded-r-full transition-opacity duration-200 {{ request()->routeIs('inventory.reports.*') ? 'opacity-100' : 'opacity-0' }}"></span>
<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
               <span class="font-medium text-sm">Kartu Stok</span>
            </a>
        @endcan

        @can('view_clinical')
            <a href="{{ route('clinical.records.index') }}" 
               class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('clinical.records.*') ? 'bg-blue-600/10 text-blue-400' : 'text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-500 dark:hover:text-slate-100' }}">
               <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-500 rounded-r-full transition-opacity duration-200 {{ request()->routeIs('clinical.records.*') ? 'opacity-100' : 'opacity-0' }}"></span>
               <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
               <span class="font-medium text-sm">Rekam Medis</span>
            </a>
            
            <a href="{{ route('clinical.sick-leaves.index') }}" 
               class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('clinical.sick-leaves.*') ? 'bg-blue-600/10 text-blue-400' : 'text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-500 dark:hover:text-slate-100' }}">
               <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-500 rounded-r-full transition-opacity duration-200 {{ request()->routeIs('clinical.sick-leaves.*') ? 'opacity-100' : 'opacity-0' }}"></span>
               <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>               
               <span class="font-medium text-sm">Surat Keterangan (SKD)</span>
            </a>
        
            <a href="{{ route('clinical.lab.index') }}" 
               class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('clinical.lab.*') ? 'bg-blue-600/10 text-blue-400' : 'text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-500 dark:hover:text-slate-100' }}">
               <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-500 rounded-r-full transition-opacity duration-200 {{ request()->routeIs('clinical.lab.*') ? 'opacity-100' : 'opacity-0' }}"></span>
<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
            </svg>
                           <span class="font-medium text-sm">Cek Lab</span>
            </a>
        @endcan
        
        <div class="pt-6 pb-2 px-4">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">opname</p>
        </div>

         @can('stock_opname')
            <a href="{{ route('inventory.stock-opnames.index') }}" 
               class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('inventory.stock-opnames.*') ? 'bg-blue-600/10 text-blue-400' : 'text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-500 dark:hover:text-slate-100' }}">
               <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-500 rounded-r-full transition-opacity duration-200 {{ request()->routeIs('inventory.stock-opnames.*') ? 'opacity-100' : 'opacity-0' }}"></span>
<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
               <span class="font-medium text-sm">Stock Opname</span>
            </a>
        @endcan

        <div class="pt-6 pb-2 px-4">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Laporan</p>
        </div>
        
        @can('laporan')
            <a href="{{ route('clinical.reports.index') }}" 
               class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('clinical.reports.*') ? 'bg-blue-600/10 text-blue-400' : 'text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-500 dark:hover:text-slate-100' }}">
               <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-500 rounded-r-full transition-opacity duration-200 {{ request()->routeIs('clinical.reports.*') ? 'opacity-100' : 'opacity-0' }}"></span>
               <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
               <span class="font-medium text-sm">Pusat Laporan</span>
            </a>
        @endcan

        <div class="pt-6 pb-2 px-4">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Sistem</p>
        </div>

        @can('manage_users')
            <a href="{{ route('users.index') }}" 
               class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('users.*') ? 'bg-blue-600/10 text-blue-400' : 'text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-500 dark:hover:text-slate-100' }}">
               <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-500 rounded-r-full transition-opacity duration-200 {{ request()->routeIs('users.*') ? 'opacity-100' : 'opacity-0' }}"></span>
               <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
               <span class="font-medium text-sm">Kelola User</span>
            </a>
        @endcan

        @role('superadmin')
            <a href="{{ route('permissions.index') }}" 
               class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('permissions.*') ? 'bg-blue-600/10 text-blue-400' : 'text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-500 dark:hover:text-slate-100' }}">
               <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-500 rounded-r-full transition-opacity duration-200 {{ request()->routeIs('permissions.*') ? 'opacity-100' : 'opacity-0' }}"></span>
               <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
               <span class="font-medium text-sm">Hak Akses</span>
            </a>
        @endrole

        @can('manage_whatsapp')
            <a href="{{ route('settings.whatsapp') }}" 
            class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('settings.whatsapp') ? 'bg-blue-600/10 text-blue-400' : 'text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-500 dark:hover:text-slate-100' }}">
                
                <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-500 rounded-r-full transition-opacity duration-200 {{ request()->routeIs('settings.whatsapp') ? 'opacity-100' : 'opacity-0' }}"></span>
                
                <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('settings.whatsapp') ? 'text-blue-400' : 'text-slate-400 dark:text-slate-400 dark:group-hover:text-slate-100' }}" 
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                
                <span class="font-medium text-sm">WhatsApp Bot</span>
                
                {{-- Indikator Dot Aktif --}}
                @if(request()->routeIs('settings.whatsapp'))
                    <span class="ml-auto flex h-1.5 w-1.5 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.5)]"></span>
                @endif
            </a>
        @endcan

        <div class="h-20"></div>
    </nav>

    <div class="absolute bottom-0 left-0 w-full p-4 border-t bg-white border-slate-200 dark:border-slate-800 dark:bg-slate-900 z-10 transition-colors duration-300">
        <div x-data="{ userOpen: false }" class="relative">
            <button @click="userOpen = !userOpen" class="flex items-center w-full p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200 group focus:outline-none">
                <div class="flex-shrink-0 w-9 h-9 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center text-white font-bold shadow-lg shadow-blue-500/20">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="ml-3 text-left overflow-hidden">
                    <p class="text-sm font-semibold dark:text-white text-slate-800 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-500 truncate group-hover:text-slate-500 transition-colors">Lihat Profil</p>
                </div>
                <svg class="ml-auto w-4 h-4 text-slate-500 group-hover:text-white transition-colors" :class="{'rotate-180': userOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div x-show="userOpen" 
                 x-cloak 
                 @click.away="userOpen = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-2"
                 class="absolute bottom-16 left-0 w-full bg-white border border-slate-200 
                dark:bg-slate-900 dark:border-slate-800 rounded-xl shadow-2xl overflow-hidden py-1 z-50 transition-colors duration-300">
                
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-sm text-slate-400 hover:text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profile Saya
                </a>
                <button 
                    x-data="{ 
                        isDark: document.documentElement.classList.contains('dark') 
                    }" 
                    @click="
                        isDark = !isDark;
                        if (isDark) {
                            document.documentElement.classList.add('dark');
                            localStorage.setItem('theme', 'dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                            localStorage.setItem('theme', 'light');
                        }
                    "
                    type="button"
                    class="flex items-center w-full px-4 py-3 text-sm
                           text-slate-400 hover:bg-slate-50 hover:text-slate-500
                           dark:text-slate-300 dark:hover:bg-slate-700 dark:hover:text-white"
                >
                    <div class="w-5 h-5 mr-3 flex items-center justify-center">
                        <svg x-show="isDark" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <svg x-show="!isDark" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    </div>
                    <span x-text="isDark ? 'Ganti ke Terang' : 'Ganti ke Gelap'"></span>
                </button>
                <div class="border-t border-slate-200 dark:border-slate-700 my-1"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); this.closest('form').submit();" 
                       class="flex items-center px-4 py-3 text-sm text-red-400 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-red-500 transition-colors">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Log Out
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Mode Terang (Default) */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #334155; /* Slate 700 */
        border-radius: 20px;
    }

    /* Mode Gelap - Jika menggunakan class .dark pada tag <html> atau <body> */
    .dark .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #94a3b8; /* Slate 400 - Lebih terang agar terlihat di bg gelap */
    }

    /* Alternatif Mode Gelap - Mengikuti sistem operasi */
    @media (prefers-color-scheme: dark) {
        :not(.dark) .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #94a3b8;
        }
    }
</style>