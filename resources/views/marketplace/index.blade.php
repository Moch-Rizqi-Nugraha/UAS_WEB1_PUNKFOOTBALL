@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="container mx-auto py-12 px-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 shadow-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 shadow-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="text-center mb-12">
            <h2 class="text-5xl font-bold text-gray-900 mb-4">⚽ Marketplace Perlengkapan</h2>
            <p class="text-xl text-gray-600">Temukan perlengkapan sepak bola berkualitas dengan harga terbaik</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition duration-300 overflow-hidden flex flex-col">
                    <!-- Product Image -->
                    <div class="relative">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                <span class="text-gray-400 text-sm">⚽ No Image</span>
                            </div>
                        @endif
                        <span class="absolute top-3 right-3 bg-gray-800 text-white px-3 py-1 rounded-full text-xs font-semibold">
                            Stok: {{ $product->stock }}
                        </span>
                    </div>
                    
                    <!-- Product Info -->
                    <div class="p-4 flex-1 flex flex-col">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mb-4 flex-1">{{ Str::limit($product->description, 80) }}</p>
                        
                    <!-- Price -->
                        <div class="border-t pt-4 mb-4">
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex gap-2">
                            <a href="{{ route('marketplace.show', $product->id) }}" class="flex-1 text-center bg-gray-700 text-white py-2 px-3 rounded-lg hover:bg-gray-800 transition font-semibold text-sm">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20">
                    <div class="text-6xl mb-4">📦</div>
                    <p class="text-gray-500 text-lg font-semibold">Tidak ada produk tersedia saat ini</p>
                    <p class="text-gray-400 text-sm mt-2">Silahkan kembali lagi nanti</p>
                </div>
            @endforelse
        </div>

        @if(auth()->check() && auth()->user()->hasRole('admin'))
            <div class="text-center mt-16">
                <a href="{{ route('admin.products.index') }}" class="inline-block bg-gray-800 text-white px-8 py-3 rounded-lg hover:bg-gray-900 transition font-semibold shadow-lg">
                    🔧 Kelola Produk (Admin)
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
