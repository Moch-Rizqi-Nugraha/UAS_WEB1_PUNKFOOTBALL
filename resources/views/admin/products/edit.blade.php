@extends('admin.layout')

@section('title', 'Edit Produk')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8">
    <h1 class="text-xl font-bold mb-6">Edit Produk</h1>
    <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PATCH')
        <div class="mb-4">
            <label for="name" class="block font-semibold mb-2">Nama Produk</label>
            <input type="text" name="name" id="name" class="border rounded px-3 py-2 w-full" value="{{ $product->name }}" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block font-semibold mb-2">Deskripsi</label>
            <textarea name="description" id="description" class="border rounded px-3 py-2 w-full" required>{{ $product->description }}</textarea>
        </div>
        <div class="mb-4">
            <label for="price" class="block font-semibold mb-2">Harga</label>
            <input type="number" name="price" id="price" class="border rounded px-3 py-2 w-full" value="{{ $product->price }}" required min="0">
        </div>
        <div class="mb-4">
            <label for="stock" class="block font-semibold mb-2">Stok</label>
            <input type="number" name="stock" id="stock" class="border rounded px-3 py-2 w-full" value="{{ $product->stock }}" required min="0">
        </div>
        <div class="mb-4">
            <label for="image" class="block font-semibold mb-2">Gambar</label>
            <input type="file" name="image" id="image" class="border rounded px-3 py-2 w-full">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-12 w-12 object-cover rounded mt-2">
            @endif
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
        <a href="{{ route('admin.products.index') }}" class="ml-4 text-gray-600 hover:underline">Batal</a>
    </form>
</div>
@endsection
