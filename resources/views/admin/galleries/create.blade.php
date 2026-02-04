@extends('admin.layout')

@section('title', 'Tambah Galeri')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Tambah Galeri Baru</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <strong>Validasi Gagal:</strong>
            <ul class="list-disc ml-5 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf

        <!-- Title -->
        <div class="mb-6">
            <label for="title" class="block text-sm font-semibold mb-2">Judul <span class="text-red-500">*</span></label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   value="{{ old('title') }}" 
                   class="w-full border rounded px-4 py-2 @error('title') border-red-500 @enderror"
                   placeholder="Masukkan judul galeri"
                   required>
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-6">
            <label for="description" class="block text-sm font-semibold mb-2">Deskripsi</label>
            <textarea id="description" 
                      name="description" 
                      rows="4"
                      class="w-full border rounded px-4 py-2 @error('description') border-red-500 @enderror"
                      placeholder="Masukkan deskripsi galeri">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image Upload -->
        <div class="mb-6">
            <label for="image" class="block text-sm font-semibold mb-2">Gambar <span class="text-red-500">*</span></label>
            <div class="border-2 border-dashed rounded-lg p-6 text-center cursor-pointer hover:border-blue-500 transition"
                 onclick="document.getElementById('image').click()">
                <input type="file" 
                       id="image" 
                       name="image" 
                       accept="image/*"
                       class="hidden"
                       onchange="previewImage(event)"
                       required>
                <div id="image-placeholder">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v4a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32 0l-3.172-3.172a4 4 0 00-5.656 0L28 20M8 20l3.172-3.172a4 4 0 015.656 0L28 20m0 0l7-7m0 0a4 4 0 014 4v20a4 4 0 01-4 4H12a4 4 0 01-4-4V12a4 4 0 014-4h16m12 20a2 2 0 11-4 0 2 2 0 014 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-600">Klik atau seret gambar ke sini</p>
                    <p class="text-xs text-gray-500">(JPG, PNG, GIF, WebP - Max 5MB)</p>
                </div>
                <img id="image-preview" class="hidden mt-4 mx-auto max-h-64 rounded" alt="Preview">
            </div>
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image Alt Text -->
        <div class="mb-6">
            <label for="image_alt" class="block text-sm font-semibold mb-2">Teks Alt Gambar</label>
            <input type="text" 
                   id="image_alt" 
                   name="image_alt" 
                   value="{{ old('image_alt') }}" 
                   class="w-full border rounded px-4 py-2"
                   placeholder="Deskripsi untuk aksesibilitas gambar">
            @error('image_alt')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Category -->
        <div class="mb-6">
            <label for="category" class="block text-sm font-semibold mb-2">Kategori</label>
            <select id="category" 
                    name="category"
                    class="w-full border rounded px-4 py-2">
                <option value="">-- Pilih atau Buat Kategori Baru --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" @selected(old('category') == $cat)>{{ $cat }}</option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">Atau ketik kategori baru di kolom kategori</p>
            @error('category')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Order -->
        <div class="mb-6">
            <label for="order" class="block text-sm font-semibold mb-2">Urutan</label>
            <input type="number" 
                   id="order" 
                   name="order" 
                   value="{{ old('order', 0) }}" 
                   min="0"
                   class="w-full border rounded px-4 py-2"
                   placeholder="0">
            <p class="text-xs text-gray-500 mt-1">Angka lebih kecil akan ditampilkan lebih dulu</p>
            @error('order')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Active Status -->
        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" 
                       name="is_active" 
                       value="1" 
                       @checked(old('is_active', true))
                       class="rounded">
                <span class="ml-2 text-sm font-medium">Aktifkan Galeri</span>
            </label>
            <p class="text-xs text-gray-500 mt-1">Galeri yang tidak aktif tidak akan ditampilkan di halaman publik</p>
        </div>

        <!-- Buttons -->
        <div class="flex gap-4 pt-6 border-t">
            <a href="{{ route('admin.galleries.index') }}" class="flex-1 text-center bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                Batal
            </a>
            <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition font-semibold">
                Simpan Galeri
            </button>
        </div>
    </form>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('image-preview');
    const placeholder = document.getElementById('image-placeholder');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
}

// Allow text input for category
document.getElementById('category').addEventListener('change', function() {
    if (this.value === '') {
        const customCategory = prompt('Masukkan nama kategori baru:');
        if (customCategory) {
            this.innerHTML += `<option value="${customCategory}" selected>${customCategory}</option>`;
            this.value = customCategory;
        }
    }
});
</script>
@endsection
