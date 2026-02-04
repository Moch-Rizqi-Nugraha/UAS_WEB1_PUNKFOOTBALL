@extends('admin.layout')

@section('title', 'Manajemen Tiket')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Manajemen Tiket</h1>
    <form method="GET" class="mb-4 flex gap-2">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari tiket..." class="border rounded px-3 py-2 w-64">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Cari</button>
        <a href="{{ route('admin.tickets.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 ml-2">Tambah Tiket</a>
    </form>
    <table class="min-w-full bg-white shadow rounded-lg mb-6">
        <thead>
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Nama Tiket</th>
                <th class="px-4 py-2">Harga</th>
                <th class="px-4 py-2">Stok</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
            <tr class="border-t">
                <td class="px-4 py-2">{{ $ticket->id }}</td>
                <td class="px-4 py-2">{{ $ticket->name }}</td>
                <td class="px-4 py-2">Rp {{ number_format($ticket->price, 0, ',', '.') }}</td>
                <td class="px-4 py-2">{{ $ticket->stock }}</td>
                <td class="px-4 py-2">
                    <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline ml-2" onclick="return confirm('Yakin hapus tiket?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>{{ $tickets->links() }}</div>
</div>
@endsection
