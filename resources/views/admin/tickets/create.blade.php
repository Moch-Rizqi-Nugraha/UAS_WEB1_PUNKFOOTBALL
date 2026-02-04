@extends('admin.layout')

@section('title', 'Tambah Tiket')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8">
    <h1 class="text-xl font-bold mb-6">Tambah Tiket</h1>
    <form method="POST" action="{{ route('admin.tickets.store') }}" class="bg-white shadow rounded-lg p-6">
        @csrf
        <div class="mb-4">
            <label for="name" class="block font-semibold mb-2">Nama Tiket</label>
            <input type="text" name="name" id="name" class="border rounded px-3 py-2 w-full" required>
        </div>
        <div class="mb-4">
            <label for="price" class="block font-semibold mb-2">Harga</label>
            <input type="number" name="price" id="price" class="border rounded px-3 py-2 w-full" required min="0">
        </div>
        <div class="mb-4">
            <label for="stock" class="block font-semibold mb-2">Stok</label>
            <input type="number" name="stock" id="stock" class="border rounded px-3 py-2 w-full" required min="0">
        </div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Tambah</button>
        <a href="{{ route('admin.tickets.index') }}" class="ml-4 text-gray-600 hover:underline">Batal</a>
    </form>
</div>
@endsection
