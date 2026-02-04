@extends('admin.layout')

@section('title', 'Tambah Artikel/Berita')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8">
    <h1 class="text-xl font-bold mb-6">Tambah Artikel/Berita</h1>
    <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6">
        @csrf
        <div class="mb-4">
            <label for="title" class="block font-semibold mb-2">Judul</label>
            <input type="text" name="title" id="title" class="border rounded px-3 py-2 w-full" required>
        </div>
        <div class="mb-4">
            <label for="content" class="block font-semibold mb-2">Konten</label>
            <textarea name="content" id="content" class="border rounded px-3 py-2 w-full" required></textarea>
        </div>
        <div class="mb-4">
            <label for="image" class="block font-semibold mb-2">Gambar</label>
            <input type="file" name="image" id="image" class="border rounded px-3 py-2 w-full">
        </div>
        <div class="mb-4">
            <label for="status" class="block font-semibold mb-2">Status</label>
            <select name="status" id="status" class="border rounded px-3 py-2 w-full">
                <option value="published">Published</option>
                <option value="draft">Draft</option>
            </select>
        </div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Tambah</button>
        <a href="{{ route('admin.articles.index') }}" class="ml-4 text-gray-600 hover:underline">Batal</a>
    </form>
</div>
@endsection
