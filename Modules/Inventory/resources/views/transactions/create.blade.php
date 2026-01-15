<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Transaksi Stok') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('inventory.transactions.store') }}" method="POST">
                @csrf
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">1. Informasi Umum</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Tipe Transaksi</label>
                            <select name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="in">Stok Masuk (Pembelian/Pengadaan)</option>
                                <option value="out">Stok Keluar (Rusak/Expired/Lainnya)</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">*Untuk Pasien, gunakan Menu Rekam Medis.</p>
                        </div>
                        
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Tanggal Transaksi</label>
                            <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Catatan / No. Referensi</label>
                            <input type="text" name="notes" placeholder="No. Faktur / Keterangan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6" x-data="transactionForm()">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="text-lg font-bold text-gray-700">2. Daftar Obat</h3>
                        <button type="button" @click="addItem()" class="bg-green-600 text-white text-sm px-3 py-1 rounded hover:bg-green-700">
                            + Tambah Baris
                        </button>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="text-left text-xs font-medium text-gray-500 uppercase w-5/12">Pilih Obat</th>
                                <th class="text-left text-xs font-medium text-gray-500 uppercase w-2/12">Jumlah</th>
                                <th class="text-left text-xs font-medium text-gray-500 uppercase w-3/12">Harga Satuan (Rp)</th>
                                <th class="w-1/12"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <template x-for="(item, index) in items" :key="index">
                                <tr>
                                    <td class="py-2 pr-2">
                                        <select :name="'items['+index+'][medicine_id]'" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                                            <option value="">-- Pilih Obat --</option>
                                            @foreach($medicines as $med)
                                                <option value="{{ $med->id }}">{{ $med->code }} - {{ $med->name }} (Stok: {{ $med->current_stock }})</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="py-2 pr-2">
                                        <input type="number" :name="'items['+index+'][quantity]'" min="1" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Qty" required>
                                    </td>
                                    <td class="py-2 pr-2">
                                        <input type="number" :name="'items['+index+'][price]'" min="0" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Harga Beli">
                                    </td>
                                    <td class="py-2 text-center">
                                        <button type="button" @click="removeItem(index)" class="text-red-600 hover:text-red-900 font-bold" x-show="items.length > 1">
                                            &times;
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <a href="{{ route('inventory.transactions.index') }}" class="text-gray-600 underline mr-4">Batal</a>
                    <button type="submit" class="bg-gray-800 text-white px-6 py-2 rounded-md hover:bg-gray-700 font-bold text-lg">
                        SIMPAN TRANSAKSI
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function transactionForm() {
            return {
                items: [
                    { medicine_id: '', quantity: '', price: '' }
                ],
                addItem() {
                    this.items.push({ medicine_id: '', quantity: '', price: '' });
                },
                removeItem(index) {
                    this.items.splice(index, 1);
                }
            }
        }
    </script>
</x-app-layout>