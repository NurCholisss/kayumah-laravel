@extends('layouts.admin')

@section('title', 'Edit Produk - KayUmah')
@section('page-title', 'Edit Produk')
@section('page-description', 'Perbarui informasi produk')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="p-6 space-y-6">
                <!-- Preview Gambar Saat Ini -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                    <div class="w-32 h-32 bg-gray-200 rounded-lg overflow-hidden">
                        @if($product->main_image)
                            <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Form fields sama dengan create, tapi dengan value existing -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                    <input type="text" name="name" id="name" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                           value="{{ old('name', $product->name) }}">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select name="category_id" id="category_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp)</label>
                        <input type="number" name="price" id="price" required min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                               value="{{ old('price', $product->price) }}">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                        <input type="number" name="stock" id="stock" required min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                               value="{{ old('stock', $product->stock) }}">
                    </div>

                    <div>
                        <label for="main_image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Baru (Opsional)</label>
                        <input type="file" name="main_image" id="main_image" accept="image/*"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Produk</label>
                    <textarea name="description" id="description" rows="4" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                <a href="{{ route('admin.products.index') }}" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                    Update Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection