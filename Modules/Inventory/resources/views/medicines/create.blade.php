<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Obat Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('inventory.medicines.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Nama Obat</label>
                            <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="Contoh: Paracetamol 500mg">
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Satuan</label>
                            <select name="unit" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Tablet">Tablet</option>
                                <option value="Strip">Strip</option>
                                <option value="Botol">Botol</option>
                                <option value="Kapsul">Kapsul</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Box">Box</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Harga Jual (Rp)</label>
                            <input type="number" name="price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required min="0">
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-400">Stok Awal</label>
                            <input type="text" value="0" disabled class="mt-1 block w-full bg-gray-100 rounded-md border-gray-300 text-gray-500 cursor-not-allowed">
                            <p class="text-xs text-gray-500 mt-1">*Stok awal selalu 0. Lakukan Transaksi Pembelian untuk menambah stok.</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-gray-700">Deskripsi / Keterangan</label>
                        <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('inventory.medicines.index') }}" class="text-gray-600 underline mr-4">Batal</a>
                        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700">Simpan Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>