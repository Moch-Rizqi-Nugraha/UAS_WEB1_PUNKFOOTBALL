@extends('admin.layout')

@section('title', 'Edit Kategori')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8">
    <h1 class="text-xl font-bold mb-6">Edit Kategori</h1>
    <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PATCH')
        <div class="mb-4">
            <label for="name" class="block font-semibold mb-2">Nama Kategori</label>
            <input type="text" name="name" id="name" class="border rounded px-3 py-2 w-full" value="{{ $category->name }}" required>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
        <a href="{{ route('admin.categories.index') }}" class="ml-4 text-gray-600 hover:underline">Batal</a>
    </form>
</div>
@endsection
