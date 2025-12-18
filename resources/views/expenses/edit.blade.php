@extends('layouts.app')

@section('title', 'Edit Pengeluaran')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Edit Pengeluaran</h2>
        </div>

        <form action="{{ route('expenses.update', $expense) }}" method="POST" class="px-6 py-6">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Keterangan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="description" 
                           id="description" 
                           value="{{ old('description', $expense->description) }}"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                           placeholder="Contoh: Beli bahan makanan">
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Amount -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                        Jumlah (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="amount" 
                           id="amount" 
                           value="{{ old('amount', $expense->amount) }}"
                           required
                           min="0"
                           step="0.01"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('amount') border-red-500 @enderror"
                           placeholder="0">
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="category" 
                            id="category" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('category') border-red-500 @enderror">
                        <option value="">Pilih Kategori</option>
                        <option value="Makanan & Minuman" {{ old('category', $expense->category) == 'Makanan & Minuman' ? 'selected' : '' }}>Makanan & Minuman</option>
                        <option value="Transportasi" {{ old('category', $expense->category) == 'Transportasi' ? 'selected' : '' }}>Transportasi</option>
                        <option value="Belanja" {{ old('category', $expense->category) == 'Belanja' ? 'selected' : '' }}>Belanja</option>
                        <option value="Hiburan" {{ old('category', $expense->category) == 'Hiburan' ? 'selected' : '' }}>Hiburan</option>
                        <option value="Kesehatan" {{ old('category', $expense->category) == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                        <option value="Pendidikan" {{ old('category', $expense->category) == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                        <option value="Tagihan" {{ old('category', $expense->category) == 'Tagihan' ? 'selected' : '' }}>Tagihan</option>
                        <option value="Lainnya" {{ old('category', $expense->category) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           name="date" 
                           id="date" 
                           value="{{ old('date', $expense->date->format('Y-m-d')) }}"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('date') border-red-500 @enderror">
                    @error('date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan
                    </label>
                    <textarea name="notes" 
                              id="notes" 
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-500 @enderror"
                              placeholder="Catatan tambahan (opsional)">{{ old('notes', $expense->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-8 flex items-center justify-end space-x-4">
                <a href="{{ route('expenses.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Update Pengeluaran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
