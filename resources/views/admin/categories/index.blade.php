@extends('layouts.admin')

@section('title', 'Kelola Kategori')
@section('subtitle', 'Daftar kategori produk furniture')

@section('content')
<div class="space-y-6">
    <!-- Header dengan Form Tambah Kategori -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Kategori</h2>
            <p class="text-gray-600">Kelola kategori produk furniture KayUmah</p>
        </div>
        
        <!-- Form Tambah Kategori -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Kategori Baru</h3>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                        <input type="text" 
                               name="name" 
                               id="name"
                               required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                               placeholder="Contoh: Kursi, Meja, Lemari">
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" 
                            class="w-full bg-amber-600 text-white py-2 px-4 rounded-lg hover:bg-amber-700 transition-colors">
                        Tambah Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($categories as $category)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">{{ $category->name }}</h3>
                <span class="bg-gray-100 text-gray-600 text-sm px-2 py-1 rounded-full">
                    {{ $category->products_count ?? $category->products->count() }} produk
                </span>
            </div>
            
            <div class="flex items-center space-x-3">
                <!-- Edit Form -->
                <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="flex-1">
                    @csrf
                    @method('PUT')
                    <div class="flex space-x-2">
                        <input type="text" 
                               name="name" 
                               value="{{ $category->name }}"
                               required
                               class="flex-1 px-3 py-1 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                        <button type="submit" 
                                class="bg-blue-600 text-white p-1 rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M5 13l4 4L19 7"/>
                            </svg>
                        </button>
                    </div>
                </form>
                
                <!-- Delete Button -->
                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-600 text-white p-1 rounded-lg hover:bg-red-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            <p class="mt-4 text-gray-500">Belum ada kategori</p>
        </div>
        @endforelse
    </div>
</div>
@endsection