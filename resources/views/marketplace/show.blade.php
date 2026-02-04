@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-96 object-cover rounded-lg mb-6">
                @endif
                
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                <div class="text-2xl font-bold text-gray-800 mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Deskripsi Produk</h3>
                    <p class="text-gray-600">{{ $product->description }}</p>
                </div>

                @if($product->stock)
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <p class="text-gray-700"><span class="font-semibold">Stok Tersedia:</span> {{ $product->stock }} unit</p>
                    </div>
                @endif

                <div class="flex gap-4">
                    <a href="{{ route('marketplace.index') }}" class="bg-gray-800 text-white px-8 py-3 rounded-lg hover:bg-gray-900 transition font-semibold">
                        Kembali ke Marketplace
                    </a>
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg h-fit">
                <h3 class="text-xl font-semibold text-gray-900 mb-6">Info Pembelian</h3>
                
                <div class="mb-4 pb-4 border-b border-gray-200">
                    <p class="text-gray-600 text-sm">Harga Satuan</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>

                <div class="mb-4 pb-4 border-b border-gray-200">
                    <p class="text-gray-600 text-sm">Kategori</p>
                    <p class="text-gray-900 font-semibold">{{ $product->category ?? 'Umum' }}</p>
                </div>

                @auth
                    <form method="POST" action="{{ route('marketplace.buy', $product->id) }}" class="mt-6">
                        @csrf
                        <button type="submit" class="w-full bg-gray-800 text-white py-3 px-4 rounded-lg hover:bg-gray-900 transition font-semibold">
                            Beli Sekarang
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="w-full block text-center bg-gray-800 text-white py-3 px-4 rounded-lg hover:bg-gray-900 transition font-semibold">
                        Login untuk Membeli
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
