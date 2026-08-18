<div x-show="sidebarOpen" 
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="sidebarOpen = false" 
     class="fixed inset-0 z-20 bg-neutral-900/80 backdrop-blur-sm md:hidden"></div>

<div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
     class="fixed inset-y-0 left-0 z-30 w-64 bg-neutral-950 text-neutral-50 transition-all duration-300 ease-in-out md:translate-x-0 md:static md:inset-0 flex flex-col border-r border-neutral-200 dark:border-neutral-600 shadow" >

    <div class="flex items-center justify-between h-[86px] px-6 bg-white dark:bg-neutral-800 border-b border-neutral-200 dark:border-neutral-600 transition-colors duration-300">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group w-full">
            <div class="relative flex items-center justify-center w-8 h-8 bg-neutral-900 dark:bg-neutral-50 rounded-md shadow group-hover:scale-105 transition-transform duration-300">
                <svg class="w-4 h-4 text-neutral-50 dark:text-neutral-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">POLIKLINIK</span>
                <span class="text-[9px] uppercase tracking-wider text-neutral-500 dark:text-neutral-500 font-medium">PT Nusantara Building Industries</span>
            </div>
        </a>
        
        <button @click="sidebarOpen = false" class="md:hidden text-neutral-500 hover:text-neutral-900 dark:hover:text-neutral-50 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto custom-scrollbar bg-neutral-50 dark:bg-neutral-800 transition-colors duration-300">
        
        @can('view_dashboard')
        
        <a href="{{ route('dashboard') }}" 
           class="flex items-center px-3 py-2 rounded-md transition-colors text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-neutral-200 dark:bg-neutral-800 text-neutral-900 dark:text-neutral-50' : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-50' }}">
            
            <svg class="w-4 h-4 mr-3 {{ request()->routeIs('dashboard') ? 'text-neutral-900 dark:text-neutral-50' : 'text-neutral-500 dark:text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Dashboard
        </a>
        @endcan

        <div class="pt-4 pb-2 px-3">
            <p class="text-xs font-semibold text-neutral-500 dark:text-neutral-500 uppercase tracking-wider">Master Data</p>
        </div>

        @can('view_master_data')
            <a href="{{ route('master.employees.index') }}" 
               class="flex items-center px-3 py-2 rounded-md transition-colors text-sm font-medium {{ request()->routeIs('master.employees.*') ? 'bg-neutral-200 dark:bg-neutral-800 text-neutral-900 dark:text-neutral-50' : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-50' }}">
                <svg class="w-4 h-4 mr-3 {{ request()->routeIs('master.employees.*') ? 'text-neutral-900 dark:text-neutral-50' : 'text-neutral-500 dark:text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Data Karyawan
            </a>

            <a href="{{ route('master.doctors.index') }}" 
               class="flex items-center px-3 py-2 rounded-md transition-colors text-sm font-medium {{ request()->routeIs('master.doctors.*') ? 'bg-neutral-200 dark:bg-neutral-800 text-neutral-900 dark:text-neutral-50' : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-50' }}">
                <svg class="w-4 h-4 mr-3 {{ request()->routeIs('master.doctors.*') ? 'text-neutral-900 dark:text-neutral-50' : 'text-neutral-500 dark:text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Data Dokter
            </a>

            <a href="{{ route('master.nurses.index') }}" 
               class="flex items-center px-3 py-2 rounded-md transition-colors text-sm font-medium {{ request()->routeIs('master.nurses.*') ? 'bg-neutral-200 dark:bg-neutral-800 text-neutral-900 dark:text-neutral-50' : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-50' }}">
               <svg class="w-4 h-4 mr-3 {{ request()->routeIs('master.nurses.*') ? 'text-neutral-900 dark:text-neutral-50' : 'text-neutral-500 dark:text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
               Data Perawat
            </a>

            <a href="{{ route('master.patients.index') }}" 
               class="flex items-center px-3 py-2 rounded-md transition-colors text-sm font-medium {{ request()->routeIs('master.patients.*') ? 'bg-neutral-200 dark:bg-neutral-800 text-neutral-900 dark:text-neutral-50' : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-50' }}">
               <svg class="w-4 h-4 mr-3 {{ request()->routeIs('master.patients.*') ? 'text-neutral-900 dark:text-neutral-50' : 'text-neutral-500 dark:text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
               Data Pasien
            </a>
        @endcan

        @can('view_master_medicine')
            <a href="{{ route('inventory.medicines.index') }}" 
               class="flex items-center px-3 py-2 rounded-md transition-colors text-sm font-medium {{ request()->routeIs('inventory.medicines.*') ? 'bg-neutral-200 dark:bg-neutral-800 text-neutral-900 dark:text-neutral-50' : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-50' }}">
               <svg class="w-4 h-4 mr-3 {{ request()->routeIs('inventory.medicines.*') ? 'text-neutral-900 dark:text-neutral-50' : 'text-neutral-500 dark:text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
            </svg>
            Data Obat
            </a>
        @endcan

        <div class="pt-4 pb-2 px-3">
            <p class="text-xs font-semibold text-neutral-500 dark:text-neutral-500 uppercase tracking-wider">Klinis & Transaksi</p>
        </div>

        @can('view_medicine_history')
            <a href="{{ route('inventory.transactions.index') }}" 
               class="flex items-center px-3 py-2 rounded-md transition-colors text-sm font-medium {{ request()->routeIs('inventory.transactions.*') ? 'bg-neutral-200 dark:bg-neutral-800 text-neutral-900 dark:text-neutral-50' : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-50' }}">
               <svg class="w-4 h-4 mr-3 {{ request()->routeIs('inventory.transactions.*') ? 'text-neutral-900 dark:text-neutral-50' : 'text-neutral-500 dark:text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
               Transaksi Obat
            </a>
        @endcan

         @can('adjustment_obat')
            <a href="{{ route('inventory.adjustments.index') }}" 
               class="flex items-center px-3 py-2 rounded-md transition-colors text-sm font-medium {{ request()->routeIs('inventory.adjustments.*') ? 'bg-neutral-200 dark:bg-neutral-800 text-neutral-900 dark:text-neutral-50' : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-50' }}">
               <svg class="w-4 h-4 mr-3 {{ request()->routeIs('inventory.adjustments.*') ? 'text-neutral-900 dark:text-neutral-50' : 'text-neutral-500 dark:text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
               Adjustment Obat
            </a>
             <a href="{{ route('inventory.reports.stock_card') }}" 
               class="flex items-center px-3 py-2 rounded-md transition-colors text-sm font-medium {{ request()->routeIs('inventory.reports.*') ? 'bg-neutral-200 dark:bg-neutral-800 text-neutral-900 dark:text-neutral-50' : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-50' }}">
               <svg class="w-4 h-4 mr-3 {{ request()->routeIs('inventory.reports.*') ? 'text-neutral-900 dark:text-neutral-50' : 'text-neutral-500 dark:text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
               Kartu Stok
            </a>
        @endcan

        @can('view_clinical')
            <a href="{{ route('clinical.records.index') }}" 
               class="flex items-center px-3 py-2 rounded-md transition-colors text-sm font-medium {{ request()->routeIs('clinical.records.*') ? 'bg-neutral-200 dark:bg-neutral-800 text-neutral-900 dark:text-neutral-50' : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-50' }}">
               <svg class="w-4 h-4 mr-3 {{ request()->routeIs('clinical.records.*') ? 'text-neutral-900 dark:text-neutral-50' : 'text-neutral-500 dark:text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
               Rekam Medis
            </a>
            
            <a href="{{ route('clinical.sick-leaves.index') }}" 
               class="flex items-center px-3 py-2 rounded-md transition-colors text-sm font-medium {{ request()->routeIs('clinical.sick-leaves.*') ? 'bg-neutral-200 dark:bg-neutral-800 text-neutral-900 dark:text-neutral-50' : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-50' }}">
               <svg class="w-4 h-4 mr-3 {{ request()->routeIs('clinical.sick-leaves.*') ? 'text-neutral-900 dark:text-neutral-50' : 'text-neutral-500 dark:text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>               
               Surat Keterangan (SKD)
            </a>
        
            <a href="{{ route('clinical.lab.index') }}" 
               class="flex items-center px-3 py-2 rounded-md transition-colors text-sm font-medium {{ request()->routeIs('clinical.lab.*') ? 'bg-neutral-200 dark:bg-neutral-800 text-neutral-900 dark:text-neutral-50' : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-50' }}">
               <svg class="w-4 h-4 mr-3 {{ request()->routeIs('clinical.lab.*') ? 'text-neutral-900 dark:text-neutral-50' : 'text-neutral-500 dark:text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
            </svg>
            Cek Lab
            </a>
        @endcan
        
        <div class="pt-4 pb-2 px-3">
            <p class="text-xs font-semibold text-neutral-500 dark:text-neutral-500 uppercase tracking-wider">Opname</p>
        </div>

         @can('stock_opname')
            <a href="{{ route('inventory.stock-opnames.index') }}" 
               class="flex items-center px-3 py-2 rounded-md transition-colors text-sm font-medium {{ request()->routeIs('inventory.stock-opnames.*') ? 'bg-neutral-200 dark:bg-neutral-800 text-neutral-900 dark:text-neutral-50' : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-50' }}">
               <svg class="w-4 h-4 mr-3 {{ request()->routeIs('inventory.stock-opnames.*') ? 'text-neutral-900 dark:text-neutral-50' : 'text-neutral-500 dark:text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
               Stock Opname
            </a>
        @endcan

        <div class="pt-4 pb-2 px-3">
            <p class="text-xs font-semibold text-neutral-500 dark:text-neutral-500 uppercase tracking-wider">Laporan</p>
        </div>
        
        @can('laporan')
            <a href="{{ route('clinical.reports.index') }}" 
               class="flex items-center px-3 py-2 rounded-md transition-colors text-sm font-medium {{ request()->routeIs('clinical.reports.*') ? 'bg-neutral-200 dark:bg-neutral-800 text-neutral-900 dark:text-neutral-50' : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-50' }}">
               <svg class="w-4 h-4 mr-3 {{ request()->routeIs('clinical.reports.*') ? 'text-neutral-900 dark:text-neutral-50' : 'text-neutral-500 dark:text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
               Pusat Laporan
            </a>
        @endcan

        <div class="pt-4 pb-2 px-3">
            <p class="text-xs font-semibold text-neutral-500 dark:text-neutral-500 uppercase tracking-wider">Sistem</p>
        </div>

        @can('manage_users')
            <a href="{{ route('users.index') }}" 
               class="flex items-center px-3 py-2 rounded-md transition-colors text-sm font-medium {{ request()->routeIs('users.*') ? 'bg-neutral-200 dark:bg-neutral-800 text-neutral-900 dark:text-neutral-50' : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-50' }}">
               <svg class="w-4 h-4 mr-3 {{ request()->routeIs('users.*') ? 'text-neutral-900 dark:text-neutral-50' : 'text-neutral-500 dark:text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
               Kelola User
            </a>
        @endcan

        @role('superadmin')
            <a href="{{ route('permissions.index') }}" 
               class="flex items-center px-3 py-2 rounded-md transition-colors text-sm font-medium {{ request()->routeIs('permissions.*') ? 'bg-neutral-200 dark:bg-neutral-800 text-neutral-900 dark:text-neutral-50' : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-50' }}">
               <svg class="w-4 h-4 mr-3 {{ request()->routeIs('permissions.*') ? 'text-neutral-900 dark:text-neutral-50' : 'text-neutral-500 dark:text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
               Hak Akses
            </a>
        @endrole

        @can('manage_whatsapp')
            <a href="{{ route('settings.whatsapp') }}" 
            class="flex items-center px-3 py-2 rounded-md transition-colors text-sm font-medium {{ request()->routeIs('settings.whatsapp') ? 'bg-neutral-200 dark:bg-neutral-800 text-neutral-900 dark:text-neutral-50' : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-50' }}">
                
                <svg class="w-4 h-4 mr-3 {{ request()->routeIs('settings.whatsapp') ? 'text-neutral-900 dark:text-neutral-50' : 'text-neutral-500 dark:text-neutral-400' }}" 
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                
                WhatsApp Bot
            </a>
        @endcan

        <div class="h-20"></div>
    </nav>

    <div class="absolute bottom-0 left-0 w-full p-4 border-t bg-neutral-50 border-neutral-200 dark:border-neutral-600 dark:bg-neutral-800 z-10 transition-colors duration-300">
        <div x-data="{ userOpen: false }" class="relative">
            <button @click="userOpen = !userOpen" class="flex items-center w-full p-2 rounded-md hover:bg-neutral-200 dark:hover:bg-neutral-700 transition-colors focus:outline-none">
                <div class="flex-shrink-0 w-8 h-8 bg-neutral-900 dark:bg-neutral-50 rounded flex items-center justify-center text-neutral-50 dark:text-neutral-900 text-sm font-semibold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="ml-3 text-left overflow-hidden">
                    <p class="text-sm font-medium text-neutral-900 dark:text-neutral-50 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-neutral-500 truncate">Pengaturan</p>
                </div>
                <svg class="ml-auto w-4 h-4 text-neutral-500" :class="{'rotate-180': userOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div x-show="userOpen" 
                 x-cloak 
                 @click.away="userOpen = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute bottom-14 left-0 w-full bg-white border border-neutral-200 dark:bg-neutral-800 dark:border-neutral-600 rounded-md shadow-md overflow-hidden py-1 z-50">
                
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:hover:text-neutral-50 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
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
                    class="flex items-center w-full px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:hover:text-neutral-50 transition-colors"
                >
                    <div class="w-4 h-4 mr-2 flex items-center justify-center">
                        <svg x-show="isDark" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <svg x-show="!isDark" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    </div>
                    <span x-text="isDark ? 'Ganti ke Terang' : 'Ganti ke Gelap'"></span>
                </button>
                <div class="border-t border-neutral-200 dark:border-neutral-600 my-1"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); this.closest('form').submit();" 
                       class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-neutral-100 dark:text-red-500 dark:hover:bg-neutral-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
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
        background-color: #cbd5e1; /* Slate 300 */
        border-radius: 4px;
    }

    /* Mode Gelap */
    .dark .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #404040; /* Slate 700 */
    }

    /* Hover State */
    .custom-scrollbar:hover::-webkit-scrollbar-thumb {
        background-color: #a1a1a1; /* Slate 400 */
    }
    .dark .custom-scrollbar:hover::-webkit-scrollbar-thumb {
        background-color: #525252; /* Slate 600 */
    }
</style>