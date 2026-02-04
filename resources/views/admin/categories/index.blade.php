@extends('admin.layout')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Manajemen Kategori</h1>
    <form method="GET" class="mb-4 flex gap-2">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari kategori..." class="border rounded px-3 py-2 w-64">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Cari</button>
        <a href="{{ route('admin.categories.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 ml-2">Tambah Kategori</a>
    </form>
    <table class="min-w-full bg-white shadow rounded-lg mb-6">
        <thead>
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Nama Kategori</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr class="border-t">
                <td class="px-4 py-2">{{ $category->id }}</td>
                <td class="px-4 py-2">{{ $category->name }}</td>
                <td class="px-4 py-2">
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline ml-2" onclick="return confirm('Yakin hapus kategori?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>{{ $categories->links() }}</div>
</div>
@endsection
