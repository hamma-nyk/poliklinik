<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Obat') }}: {{ $medicine->code }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('inventory.medicines.update', $medicine->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Nama Obat</label>
                            <input type="text" name="name" value="{{ $medicine->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Satuan</label>
                            <select name="unit" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Tablet" {{ $medicine->unit == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                                <option value="Strip" {{ $medicine->unit == 'Strip' ? 'selected' : '' }}>Strip</option>
                                <option value="Botol" {{ $medicine->unit == 'Botol' ? 'selected' : '' }}>Botol</option>
                                <option value="Kapsul" {{ $medicine->unit == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                                <option value="Pcs" {{ $medicine->unit == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                                <option value="Box" {{ $medicine->unit == 'Box' ? 'selected' : '' }}>Box</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Harga Jual (Rp)</label>
                            <input type="number" name="price" value="{{ $medicine->price }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required min="0">
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-400">Stok Saat Ini</label>
                            <input type="text" value="{{ $medicine->current_stock }}" disabled class="mt-1 block w-full bg-gray-100 rounded-md border-gray-300 text-gray-800 font-bold cursor-not-allowed">
                            <p class="text-xs text-gray-500 mt-1">*Stok tidak bisa diedit manual disini.</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-gray-700">Deskripsi / Keterangan</label>
                        <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $medicine->description }}</textarea>
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('inventory.medicines.index') }}" class="text-gray-600 underline mr-4">Batal</a>
                        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700">Update Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>