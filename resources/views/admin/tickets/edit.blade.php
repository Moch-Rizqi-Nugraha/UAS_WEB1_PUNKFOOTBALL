@extends('admin.layout')

@section('title', 'Edit Tiket')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8">
    <h1 class="text-xl font-bold mb-6">Edit Tiket</h1>
    <form method="POST" action="{{ route('admin.tickets.update', $ticket->id) }}" class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PATCH')
        <div class="mb-4">
            <label for="name" class="block font-semibold mb-2">Nama Tiket</label>
            <input type="text" name="name" id="name" class="border rounded px-3 py-2 w-full" value="{{ $ticket->name }}" required>
        </div>
        <div class="mb-4">
            <label for="price" class="block font-semibold mb-2">Harga</label>
            <input type="number" name="price" id="price" class="border rounded px-3 py-2 w-full" value="{{ $ticket->price }}" required min="0">
        </div>
        <div class="mb-4">
            <label for="stock" class="block font-semibold mb-2">Stok</label>
            <input type="number" name="stock" id="stock" class="border rounded px-3 py-2 w-full" value="{{ $ticket->stock }}" required min="0">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
        <a href="{{ route('admin.tickets.index') }}" class="ml-4 text-gray-600 hover:underline">Batal</a>
    </form>
</div>
@endsection
