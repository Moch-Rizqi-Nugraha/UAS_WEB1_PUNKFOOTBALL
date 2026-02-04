@extends('admin.layout')

@section('title', 'Edit Artikel/Berita')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8">
    <h1 class="text-xl font-bold mb-6">Edit Artikel/Berita</h1>
    <form method="POST" action="{{ route('admin.articles.update', $article->id) }}" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PATCH')
        <div class="mb-4">
            <label for="title" class="block font-semibold mb-2">Judul</label>
            <input type="text" name="title" id="title" class="border rounded px-3 py-2 w-full" value="{{ $article->title }}" required>
        </div>
        <div class="mb-4">
            <label for="content" class="block font-semibold mb-2">Konten</label>
            <textarea name="content" id="content" class="border rounded px-3 py-2 w-full" required>{{ $article->content }}</textarea>
        </div>
        <div class="mb-4">
            <label for="image" class="block font-semibold mb-2">Gambar</label>
            <input type="file" name="image" id="image" class="border rounded px-3 py-2 w-full">
            @if($article->image)
                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="h-12 w-12 object-cover rounded mt-2">
            @endif
        </div>
        <div class="mb-4">
            <label for="status" class="block font-semibold mb-2">Status</label>
            <select name="status" id="status" class="border rounded px-3 py-2 w-full">
                <option value="published" {{ $article->status == 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ $article->status == 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
        <a href="{{ route('admin.articles.index') }}" class="ml-4 text-gray-600 hover:underline">Batal</a>
    </form>
</div>
@endsection
