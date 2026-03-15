<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 transition-all duration-300">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-100 leading-tight tracking-tight">
                    {{ __('WhatsApp Service Gateway') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400 font-medium">Manajemen koneksi bot notifikasi otomatis</p>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800/50 rounded-xl">
                <div class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></div>
                <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">Server Engine Active</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-slate-900 min-h-screen transition-colors duration-300" 
         x-data="whatsappService()" 
         x-init="initService()">
        
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Status Card (Lapis 800) --}}
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] p-10 shadow-sm border border-slate-200 dark:border-slate-700 transition-all">
                <div class="flex items-center justify-between mb-10">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-2xl" :class="status === 'connected' ? 'bg-emerald-50 dark:bg-emerald-900/30' : 'bg-rose-50 dark:bg-rose-900/30'">
                            <div :class="status === 'connected' ? 'bg-emerald-500' : 'bg-rose-500'" 
                                 class="w-3 h-3 rounded-full animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                        </div>
                        <h3 class="text-sm font-bold text-slate-700 dark:text-slate-200 uppercase tracking-[0.2em]" x-text="serviceName"></h3>
                    </div>
                    
                    <button @click="logout()" x-show="status === 'connected'" 
                            class="px-5 py-2.5 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 text-[10px] font-bold rounded-xl border border-rose-100 dark:border-rose-800 hover:bg-rose-600 hover:text-white dark:hover:bg-rose-700 transition-all active:scale-95 uppercase tracking-widest shadow-sm">
                        Disconnect Device
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    {{-- QR Section (Lapis 900) --}}
                    <div class="flex flex-col items-center justify-center p-8 bg-slate-50 dark:bg-slate-900/50 rounded-[2rem] border-2 border-dashed border-slate-200 dark:border-slate-700 min-h-[350px] transition-all">
                        
                        {{-- State: Connected --}}
                        <template x-if="status === 'connected'">
                            <div class="text-center space-y-4" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-90">
                                <div class="bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 p-6 rounded-[2rem] inline-block shadow-lg shadow-emerald-500/10">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Session Active</p>
                                    <h4 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight" x-text="connectedNumber"></h4>
                                </div>
                            </div>
                        </template>

                        {{-- State: QR Ready --}}
                        <template x-if="status === 'qr_ready'">
                            <div class="text-center space-y-6" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 transform translate-y-4">
                                <div class="relative inline-block group">
                                    <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-emerald-500 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                                    <img :src="qrCode" alt="WA QR Code" class="relative w-56 h-56 border-8 border-white dark:border-slate-800 shadow-2xl rounded-2xl transition-transform hover:scale-105">
                                </div>
                                <div class="space-y-1">
                                    <p class="text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Otorisasi Perangkat</p>
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 italic animate-pulse">Scan QR Code melalui WhatsApp Linked Devices</p>
                                </div>
                            </div>
                        </template>

                        {{-- State: Loading/Disconnected --}}
                        <template x-if="status === 'disconnected'">
                            <div class="text-center space-y-4">
                                <div class="w-12 h-12 border-4 border-slate-200 dark:border-slate-700 border-t-indigo-500 rounded-full animate-spin mx-auto"></div>
                                <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Inisialisasi Service...</p>
                            </div>
                        </template>
                    </div>

                    {{-- Info Section (Lapis 700 Area) --}}
                    <div class="space-y-6">
                        <div class="p-6 bg-indigo-50 dark:bg-slate-700 rounded-3xl border border-indigo-100 dark:border-slate-600 transition-all">
                            <h4 class="text-[10px] font-bold text-indigo-400 dark:text-indigo-400 uppercase tracking-[0.2em] mb-2">Engine Status</h4>
                            <p class="text-lg font-bold text-indigo-700 dark:text-indigo-300 capitalize flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-indigo-500 shadow-[0_0_8px_rgba(99,102,241,0.6)]"></span>
                                <span x-text="status"></span>
                            </p>
                        </div>
                        
                        <div class="p-6 bg-slate-100 dark:bg-slate-700/50 rounded-3xl border border-slate-200 dark:border-slate-700 transition-all">
                            <h4 class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-2">Internal Endpoint</h4>
                            <p class="text-sm font-bold text-slate-700 dark:text-slate-200 font-mono tracking-tight">
                                http://localhost:<span class="text-indigo-500">3001</span>
                            </p>
                        </div>
                        
                        <div class="flex items-start gap-3 px-2">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-[10px] text-slate-400 dark:text-slate-500 italic leading-relaxed">
                                Gateway ini menghandle integrasi notifikasi pengadaan barang, rekam medis pasien, dan hasil lab secara real-time melalui protokol Baileys.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Log Section (Lapis 900 Background) --}}
            <div class="bg-slate-900 rounded-[2rem] p-8 shadow-2xl border border-slate-800 overflow-hidden relative group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-30 transition-opacity">
                    <svg class="w-24 h-24 text-indigo-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm3.293 1.293a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L7.586 10 5.293 7.707a1 1 0 010-1.414zM11 12a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                </div>
                
                <div class="flex items-center justify-between mb-6 relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                        <h3 class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em]">Live Activity Log</h3>
                    </div>
                    <span class="text-[9px] font-bold text-emerald-500/70 font-mono bg-emerald-500/10 px-2 py-1 rounded-md border border-emerald-500/20">wa_engine.sys</span>
                </div>

                <div class="h-56 overflow-y-auto font-mono text-[11px] space-y-2 text-slate-400 custom-scrollbar pr-4" id="log-container">
                    <template x-for="log in logs">
                        <div class="flex gap-4 border-l-2 border-slate-800 pl-4 py-0.5 hover:bg-slate-800/30 transition-colors">
                            <span class="text-slate-600 shrink-0 font-bold" x-text="log.time"></span>
                            <span :class="log.type === 'error' ? 'text-rose-400' : 'text-emerald-400'" x-text="log.message"></span>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </div>

    <script>
        function whatsappService() {
            return {
                status: 'disconnected',
                qrCode: null,
                connectedNumber: null,
                serviceName: 'WhatsApp Loader...',
                logs: [],
                apiUrl: 'http://localhost:3001/api',

                async initService() {
                    this.addLog('Menghubungkan ke API Bot...', 'info');
                    this.checkStatus();
                    // Polling status setiap 5 detik
                    setInterval(() => this.checkStatus(), 5000);
                },

                async checkStatus() {
                    try {
                        const res = await fetch(`${this.apiUrl}/status`);
                        const data = await res.json();
                        
                        this.status = data.status;
                        this.serviceName = data.service;
                        this.connectedNumber = data.user;

                        if (this.status === 'qr_ready') {
                            this.fetchQR();
                        } else if (this.status === 'connected') {
                            this.qrCode = null;
                        }
                    } catch (e) {
                        this.status = 'disconnected';
                        this.addLog('Gagal koneksi ke server Node.js', 'error');
                    }
                },

                async fetchQR() {
                    try {
                        const res = await fetch(`${this.apiUrl}/qr`);
                        const data = await res.json();
                        if (data.success) {
                            this.qrCode = data.qr;
                            this.addLog('QR Code diperbarui, menunggu scan...', 'info');
                        }
                    } catch (e) {
                        this.addLog('Gagal mengambil QR Code', 'error');
                    }
                },

                async logout() {
                    if(!confirm('Putuskan koneksi WhatsApp?')) return;
                    try {
                        await fetch(`${this.apiUrl}/logout`, { method: 'POST' });
                        this.addLog('Memutuskan koneksi...', 'info');
                        this.checkStatus();
                    } catch (e) {
                        this.addLog('Gagal logout', 'error');
                    }
                },

                addLog(message, type) {
                    const time = new Date().toLocaleTimeString();
                    this.logs.unshift({ time, message, type });
                    if (this.logs.length > 50) this.logs.pop();
                }
            }
        }
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #475569; }
    </style>
</x-app-layout>