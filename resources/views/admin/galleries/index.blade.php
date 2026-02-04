@extends('admin.layout')

@section('title', 'Manajemen Galeri')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Manajemen Galeri</h1>
        <a href="{{ route('admin.galleries.create') }}" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
            <span class="mr-2">+</span>Tambah Galeri
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filter Section -->
    <div class="mb-6 bg-white p-4 rounded-lg shadow">
        <form method="GET" action="{{ route('admin.galleries.index') }}" class="flex gap-4 items-end">
            <div class="flex-1">
                <label class="block text-sm font-medium mb-1">Kategori</label>
                <select name="category" class="w-full border rounded px-3 py-2">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" @selected(request('category') == $category)>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                Filter
            </button>
        </form>
    </div>

    <!-- Gallery Grid -->
    @if($galleries->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($galleries as $gallery)
                <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
                    <!-- Image -->
                    <div class="relative overflow-hidden bg-gray-200 h-48">
                        <img src="{{ asset('storage/' . $gallery->image) }}" 
                             alt="{{ $gallery->image_alt ?? $gallery->title }}" 
                             class="w-full h-full object-cover hover:scale-105 transition duration-300">
                        
                        <!-- Status Badge -->
                        <div class="absolute top-2 right-2">
                            @if($gallery->is_active)
                                <span class="bg-green-500 text-white px-2 py-1 rounded text-xs font-semibold">Aktif</span>
                            @else
                                <span class="bg-red-500 text-white px-2 py-1 rounded text-xs font-semibold">Nonaktif</span>
                            @endif
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2 truncate">{{ $gallery->title }}</h3>
                        
                        @if($gallery->category)
                            <p class="text-xs text-gray-500 mb-2">
                                <span class="bg-gray-100 px-2 py-1 rounded">{{ $gallery->category }}</span>
                            </p>
                        @endif

                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $gallery->description }}</p>

                        <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                            <span>Order: {{ $gallery->order }}</span>
                            <span>{{ $gallery->created_at->format('d M Y') }}</span>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2 pt-4 border-t">
                            <a href="{{ route('admin.galleries.show', $gallery->id) }}" 
                               class="flex-1 text-center bg-blue-500 text-white px-3 py-2 rounded text-sm hover:bg-blue-600 transition">
                                Lihat
                            </a>
                            <a href="{{ route('admin.galleries.edit', $gallery->id) }}" 
                               class="flex-1 text-center bg-yellow-500 text-white px-3 py-2 rounded text-sm hover:bg-yellow-600 transition">
                                Edit
                            </a>
                            <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" 
                                  method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-500 text-white px-3 py-2 rounded text-sm hover:bg-red-600 transition"
                                        onclick="return confirm('Yakin ingin menghapus?')">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $galleries->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 text-lg mb-4">Belum ada galeri</p>
            <a href="{{ route('admin.galleries.create') }}" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                Buat Galeri Pertama
            </a>
        </div>
    @endif
</div>
@endsection
