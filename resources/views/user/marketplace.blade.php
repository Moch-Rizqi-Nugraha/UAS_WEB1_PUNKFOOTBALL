<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Marketplace - Punk Football</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }

        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .tab-active {
            border-bottom: 3px solid #dc2626;
        }

        .tab-inactive {
            border-bottom: 3px solid transparent;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    @include('user.partials.navbar')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-4xl font-black text-gray-900">Marketplace</h1>
                    <p class="text-gray-600 mt-2">Belanja perlengkapan sepak bola berkualitas</p>
                </div>
                <a href="{{ route('user.dashboard') }}" class="bg-gray-600 text-white hover:bg-gray-700 px-6 py-2 rounded-lg font-bold transition">Kembali</a>
            </div>

            <!-- Tabs -->
            <div class="flex space-x-8 border-b border-gray-200 mb-8" x-data="{ tab: 'products' }">
                <button @click="tab = 'products'" :class="tab === 'products' ? 'tab-active' : 'tab-inactive'" class="py-4 px-2 font-bold text-gray-700 hover:text-gray-900 transition">
                    <span class="text-lg">🛒 Jelajahi Produk</span>
                </button>
                <button @click="tab = 'purchases'" :class="tab === 'purchases' ? 'tab-active' : 'tab-inactive'" class="py-4 px-2 font-bold text-gray-700 hover:text-gray-900 transition">
                    <span class="text-lg">📦 Riwayat Pembelian ({{ $stats['total_purchases'] ?? 0 }})</span>
                </button>
            </div>

            <!-- Tab: Browse Products -->
            <div x-show="tab === 'products'" class="animate-slide-in" x-transition>
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="card-hover bg-white p-6 rounded-2xl shadow-lg border-l-4 border-red-500">
                        <p class="text-gray-600 text-sm font-medium">Total Belanja</p>
                        <p class="text-3xl font-black text-gray-900 mt-2">Rp {{ number_format($stats['total_spent'] ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="card-hover bg-white p-6 rounded-2xl shadow-lg border-l-4 border-green-500">
                        <p class="text-gray-600 text-sm font-medium">Pembelian Selesai</p>
                        <p class="text-3xl font-black text-gray-900 mt-2">{{ $stats['completed'] ?? 0 }}</p>
                    </div>
                    <div class="card-hover bg-white p-6 rounded-2xl shadow-lg border-l-4 border-blue-500">
                        <p class="text-gray-600 text-sm font-medium">Pembelian Pending</p>
                        <p class="text-3xl font-black text-gray-900 mt-2">{{ $stats['pending'] ?? 0 }}</p>
                    </div>
                    <div class="card-hover bg-white p-6 rounded-2xl shadow-lg border-l-4 border-purple-500">
                        <p class="text-gray-600 text-sm font-medium">Total Transaksi</p>
                        <p class="text-3xl font-black text-gray-900 mt-2">{{ $stats['total_purchases'] ?? 0 }}</p>
                    </div>
                </div>

                <!-- Products Grid -->
                @php
                    $products = \App\Models\Product::orderBy('created_at', 'desc')->paginate(12);
                @endphp

                @if($products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        @foreach($products as $product)
                            <div class="card-hover bg-white rounded-2xl overflow-hidden shadow-lg">
                                <!-- Product Image -->
                                <div class="relative h-48 bg-gradient-to-br from-gray-200 to-gray-300 overflow-hidden">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute top-3 right-3 bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold">
                                        Stok: {{ $product->stock }}
                                    </div>
                                </div>

                                <!-- Product Info -->
                                <div class="p-5">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ $product->name }}</h3>
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>

                                    <!-- Price -->
                                    <div class="border-t pt-4 mb-4">
                                        <p class="text-3xl font-black text-red-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    </div>

                                    <!-- Action Buttons -->
                                    @if($product->stock > 0)
                                        <form method="POST" action="{{ route('marketplace.buy', $product->id) }}" class="mb-2">
                                            @csrf
                                            <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded-lg font-bold hover:bg-red-700 transition text-sm">
                                                Beli Sekarang
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="w-full bg-gray-300 text-gray-500 py-2 px-4 rounded-lg font-bold cursor-not-allowed text-sm">
                                            Stok Habis
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Produk Belum Tersedia</h3>
                        <p class="text-gray-600">Marketplace sedang dipersiapkan. Silakan kembali lagi nanti.</p>
                    </div>
                @endif
            </div>

            <!-- Tab: Purchase History -->
            <div x-show="tab === 'purchases'" class="animate-slide-in" x-transition>
                @if($transactions->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        @foreach($transactions as $transaction)
                            <div class="card-hover bg-white p-6 rounded-2xl shadow-lg border-l-4 border-blue-500">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-gray-900 line-clamp-2">{{ $transaction->item_name ?? $transaction->product?->name ?? 'Produk' }}</h3>
                                        <p class="text-xs text-gray-500 mt-1">ID: #{{ $transaction->id }}</p>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-bold rounded-full whitespace-nowrap
                                        @if($transaction->status === 'completed')
                                            bg-green-100 text-green-800
                                        @elseif($transaction->status === 'pending')
                                            bg-yellow-100 text-yellow-800
                                        @else
                                            bg-blue-100 text-blue-800
                                        @endif">
                                        @if($transaction->status === 'completed')
                                            ✓ Selesai
                                        @elseif($transaction->status === 'pending')
                                            ⏳ Pending
                                        @else
                                            📦 {{ ucfirst($transaction->status) }}
                                        @endif
                                    </span>
                                </div>

                                <div class="space-y-3 mb-4 pb-4 border-b border-gray-200">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Harga Satuan:</span>
                                        <span class="font-bold text-gray-900">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Jumlah:</span>
                                        <span class="font-bold text-gray-900">{{ $transaction->transaction_data['quantity'] ?? 1 }} pcs</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Total Pembayaran:</span>
                                        <span class="font-bold text-red-600 text-base">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center text-xs text-gray-600 mb-4">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($transaction->transaction_date ?? $transaction->created_at)->format('d M Y, H:i') }}</span>
                                </div>

                                <div class="flex gap-2">
                                    <button class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-3 rounded-lg transition font-semibold text-sm">
                                        📋 Rincian
                                    </button>
                                    @if($transaction->status === 'completed')
                                        <button class="flex-1 bg-blue-100 hover:bg-blue-200 text-blue-700 py-2 px-3 rounded-lg transition font-semibold text-sm">
                                            ⭐ Review
                                        </button>
                                    @else
                                        <button class="flex-1 bg-purple-100 hover:bg-purple-200 text-purple-700 py-2 px-3 rounded-lg transition font-semibold text-sm">
                                            📍 Status
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center mt-8">
                        {{ $transactions->links() }}
                    </div>
                @else
                    <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Belum Ada Pembelian</h3>
                        <p class="text-gray-600 mb-6">Anda belum membeli apapun. Mulai jelajahi produk kami sekarang!</p>
                        <button @click="tab = 'products'" class="bg-red-600 text-white hover:bg-red-700 px-8 py-3 rounded-xl font-bold transition">
                            🛒 Lihat Produk
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>