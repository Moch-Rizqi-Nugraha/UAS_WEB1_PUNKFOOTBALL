@extends('admin.layout')

@section('title', 'Manajemen Artikel/Berita')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Manajemen Artikel/Berita</h1>
    <form method="GET" class="mb-4 flex gap-2">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari artikel..." class="border rounded px-3 py-2 w-64">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Cari</button>
        <a href="{{ route('admin.articles.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 ml-2">Tambah Artikel</a>
    </form>
    <table class="min-w-full bg-white shadow rounded-lg mb-6">
        <thead>
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Judul</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Gambar</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $article)
            <tr class="border-t">
                <td class="px-4 py-2">{{ $article->id }}</td>
                <td class="px-4 py-2">{{ $article->title }}</td>
                <td class="px-4 py-2">
                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $article->status == 'published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($article->status) }}
                    </span>
                </td>
                <td class="px-4 py-2">
                    @if($article->image)
                        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="h-12 w-12 object-cover rounded">
                    @else
                        -
                    @endif
                </td>
                <td class="px-4 py-2">
                    <a href="{{ route('admin.articles.edit', $article->id) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline ml-2" onclick="return confirm('Yakin hapus artikel?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>{{ $articles->links() }}</div>
</div>
@endsection
