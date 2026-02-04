@extends('admin.layout')

@section('title', 'Tambah Kategori')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8">
    <h1 class="text-xl font-bold mb-6">Tambah Kategori</h1>
    <form method="POST" action="{{ route('admin.categories.store') }}" class="bg-white shadow rounded-lg p-6">
        @csrf
        <div class="mb-4">
            <label for="name" class="block font-semibold mb-2">Nama Kategori</label>
            <input type="text" name="name" id="name" class="border rounded px-3 py-2 w-full" required>
        </div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Tambah</button>
        <a href="{{ route('admin.categories.index') }}" class="ml-4 text-gray-600 hover:underline">Batal</a>
    </form>
</div>
@endsection
