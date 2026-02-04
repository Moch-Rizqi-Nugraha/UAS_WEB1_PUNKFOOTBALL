@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12">
    <div class="max-w-xl mx-auto bg-white rounded-xl shadow p-8">
        <h2 class="text-3xl font-bold mb-4">Daftar Event: {{ $event->name }}</h2>
        <p class="mb-2 text-gray-600">{{ $event->description }}</p>
        <div class="mb-4 text-sm text-gray-500">
            <span>{{ $event->event_date->format('d F Y') }}</span> | <span>{{ $event->location }}</span>
        </div>
        <form method="POST" action="#">
            @csrf
            <div class="mb-4">
                <label class="block mb-2 font-medium">Nama Lengkap</label>
                <input type="text" name="name" class="w-full border rounded px-4 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-medium">Email</label>
                <input type="email" name="email" class="w-full border rounded px-4 py-2" required>
            </div>
            <button type="submit" class="w-full bg-gray-800 text-white py-3 rounded-lg font-bold hover:bg-gray-900 transition">Daftar Sekarang</button>
        </form>
    </div>
</div>
@endsection
