@extends('admin.layout')

@section('title', 'Manajemen Produk')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Manajemen Produk</h1>
    <form method="GET" class="mb-4 flex gap-2">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari produk..." class="border rounded px-3 py-2 w-64">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Cari</button>
        <a href="{{ route('admin.products.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 ml-2">Tambah Produk</a>
    </form>
    <table class="min-w-full bg-white shadow rounded-lg mb-6">
        <thead>
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Nama Produk</th>
                <th class="px-4 py-2">Deskripsi</th>
                <th class="px-4 py-2">Harga</th>
                <th class="px-4 py-2">Stok</th>
                <th class="px-4 py-2">Gambar</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr class="border-t">
                <td class="px-4 py-2">{{ $product->id }}</td>
                <td class="px-4 py-2">{{ $product->name }}</td>
                <td class="px-4 py-2">{{ $product->description }}</td>
                <td class="px-4 py-2">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="px-4 py-2">{{ $product->stock }}</td>
                <td class="px-4 py-2">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-12 w-12 object-cover rounded">
                    @else
                        -
                    @endif
                </td>
                <td class="px-4 py-2">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline ml-2" onclick="return confirm('Yakin hapus produk?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>{{ $products->links() }}</div>
</div>
@endsection
