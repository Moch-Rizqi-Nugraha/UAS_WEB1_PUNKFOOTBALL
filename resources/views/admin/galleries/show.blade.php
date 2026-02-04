@extends('admin.layout')

@section('title', 'Detail Galeri')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ $gallery->title }}</h1>
        <div class="flex gap-2">
            @if($gallery->is_active)
                <span class="bg-green-500 text-white px-3 py-1 rounded text-sm font-semibold">Aktif</span>
            @else
                <span class="bg-red-500 text-white px-3 py-1 rounded text-sm font-semibold">Nonaktif</span>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <!-- Image -->
        <div class="mb-8">
            <img src="{{ asset('storage/' . $gallery->image) }}" 
                 alt="{{ $gallery->image_alt ?? $gallery->title }}" 
                 class="w-full h-96 object-cover rounded-lg">
        </div>

        <!-- Information Grid -->
        <div class="grid grid-cols-2 gap-6 mb-8">
            <div>
                <h3 class="text-sm font-semibold text-gray-600 mb-1">Judul</h3>
                <p class="text-lg">{{ $gallery->title }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-600 mb-1">Kategori</h3>
                <p class="text-lg">{{ $gallery->category ?? '-' }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-600 mb-1">Urutan</h3>
                <p class="text-lg">{{ $gallery->order }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-600 mb-1">Teks Alt</h3>
                <p class="text-lg">{{ $gallery->image_alt ?? '-' }}</p>
            </div>
        </div>

        <!-- Description -->
        @if($gallery->description)
            <div class="mb-8">
                <h3 class="text-sm font-semibold text-gray-600 mb-2">Deskripsi</h3>
                <p class="text-gray-700 leading-relaxed">{{ $gallery->description }}</p>
            </div>
        @endif

        <!-- Metadata -->
        <div class="mb-8 p-4 bg-gray-50 rounded">
            <h3 class="text-sm font-semibold text-gray-600 mb-2">Informasi Sistem</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-600">ID:</span>
                    <p class="font-mono">{{ $gallery->id }}</p>
                </div>
                <div>
                    <span class="text-gray-600">Dibuat:</span>
                    <p>{{ $gallery->created_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <span class="text-gray-600">Diperbarui:</span>
                    <p>{{ $gallery->updated_at->format('d M Y H:i') }}</p>
                </div>
                @if($gallery->creator)
                    <div>
                        <span class="text-gray-600">Oleh:</span>
                        <p>{{ $gallery->creator->name }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-4 pt-6 border-t">
            <a href="{{ route('admin.galleries.index') }}" class="flex-1 text-center bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                Kembali
            </a>
            <a href="{{ route('admin.galleries.edit', $gallery->id) }}" class="flex-1 text-center bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Edit
            </a>
            <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition"
                        onclick="return confirm('Yakin ingin menghapus galeri ini?')">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
