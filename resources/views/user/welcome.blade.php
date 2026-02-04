<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Dashboard - Punk Football</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .animate-slide-in {
            animation: slideInRight 0.6s ease-out forwards;
        }

        @keyframes bounce-in {
            0% {
                opacity: 0;
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-bounce-in {
            animation: bounce-in 0.5s ease-out;
        }

        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(239, 68, 68, 0.3);
            }
            50% {
                box-shadow: 0 0 30px rgba(239, 68, 68, 0.5);
            }
        }

        .glow-red {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .spin-slow {
            animation: spin-slow 20s linear infinite;
        }

        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .gradient-animate {
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
        }

        .stat-box {
            position: relative;
            overflow: hidden;
        }

        .stat-box::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .icon-box {
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .card-hover:hover .icon-box {
            transform: scale(1.2) rotate(5deg);
        }

        @keyframes wiggle {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(-5deg); }
            75% { transform: rotate(5deg); }
        }

        .wiggle:hover {
            animation: wiggle 0.5s ease-in-out;
        }

        .progress-ring {
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        .progress-ring__circle {
            transition: stroke-dashoffset 0.5s ease;
            stroke: #dc2626;
        }

        .progress-ring__bg {
            stroke: #e5e7eb;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-gray-100">
    <!-- Navigation -->
    @include('user.partials.navbar')

    <!-- Hero Welcome Section with Animated Background -->
    <section class="relative py-20 bg-gradient-to-br from-gray-900 via-slate-800 to-black text-white overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-red-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/3 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-15 animate-float" style="animation-delay: 4s;"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="animate-slide-in">
                    <div class="mb-6 inline-block">
                        <span class="bg-gradient-to-r from-red-600 to-orange-600 text-white px-6 py-3 rounded-full text-sm font-bold shadow-lg">🌟 Selamat Datang Kembali!</span>
                    </div>
                    
                    <h1 class="text-6xl md:text-7xl font-black mb-6 leading-tight">
                        <span class="text-white">Halo, </span><br>
                        <span class="bg-gradient-to-r from-red-400 via-orange-400 to-yellow-400 bg-clip-text text-transparent">{{ auth()->user()->name }}! 🎉</span>
                    </h1>
                    
                    <p class="text-xl text-gray-300 mb-10 leading-relaxed max-w-lg">
                        Tingkatkan performa sepak bola Anda dengan bergabung di event seru, berbelanja perlengkapan terbaik, dan dapatkan tiket pertandingan eksklusif.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('user.events') }}" class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-white bg-gradient-to-r from-red-600 to-red-700 rounded-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden">
                            <span class="relative z-10">⚽ Lihat Event Seru</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-red-700 to-red-800 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                        </a>
                        <a href="{{ route('user.marketplace') }}" class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-white border-2 border-white rounded-xl hover:bg-white hover:text-gray-900 transition-all duration-300 transform hover:scale-105">
                            <span>🛍️ Belanja Perlengkapan</span>
                        </a>
                    </div>
                </div>

                <!-- Right Content - Animated Card -->
                <div class="hidden lg:block animate-bounce-in">
                    <div class="relative">
                        <div class="absolute -inset-2 bg-gradient-to-r from-red-600 via-purple-600 to-blue-600 rounded-3xl blur-2xl opacity-40 group-hover:opacity-100 transition duration-1000 animate-spin-slow"></div>
                        <div class="relative bg-gradient-to-br from-gray-800 to-gray-900 rounded-3xl p-10 border border-gray-700 backdrop-blur-sm">
                            <div class="text-center">
                                <div class="w-40 h-40 mx-auto mb-6 bg-gradient-to-br from-red-500 via-orange-500 to-yellow-500 rounded-full flex items-center justify-center shadow-2xl transform hover:scale-110 transition-transform duration-300">
                                    <span class="text-8xl wiggle">⚽</span>
                                </div>
                                <h3 class="text-3xl font-bold mb-2 text-white">Punk Football</h3>
                                <p class="text-gray-400 text-lg">Platform Sepak Bola #1</p>
                                <p class="text-gray-500 text-sm mt-3">Bergabung dengan ribuan pemain lainnya</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Stats with Progress -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Event Stat -->
                <div class="card-hover group stat-box bg-gradient-to-br from-red-50 to-red-100 p-8 rounded-2xl shadow-lg border-l-4 border-red-500 relative">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-red-700 text-sm font-bold uppercase tracking-wide">Event Diikuti</p>
                            <p class="text-5xl font-black text-red-900 mt-3">{{ $stats['events_joined'] ?? 0 }}</p>
                            <p class="text-red-600 text-xs mt-2">📈 Semakin banyak semakin seru!</p>
                        </div>
                        <div class="icon-box w-20 h-20 bg-white rounded-xl shadow-lg">
                            <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Tickets Stat -->
                <div class="card-hover group stat-box bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-2xl shadow-lg border-l-4 border-blue-500 relative">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-blue-700 text-sm font-bold uppercase tracking-wide">Tiket Dimiliki</p>
                            <p class="text-5xl font-black text-blue-900 mt-3">{{ $stats['tickets'] ?? 0 }}</p>
                            <p class="text-blue-600 text-xs mt-2">🎫 Jangan lewatkan pertandingan!</p>
                        </div>
                        <div class="icon-box w-20 h-20 bg-white rounded-xl shadow-lg">
                            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m-4 0v2m4 0a1 1 0 11-2 0 1 1 0 012 0zm0 4a1 1 0 11-2 0 1 1 0 012 0m0 4a1 1 0 11-2 0 1 1 0 012 0m4-8v2m0 4v2m0-12h2a2 2 0 012 2v12a2 2 0 01-2 2h-2m0 0H7a2 2 0 01-2-2V7a2 2 0 012-2h2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Purchases Stat -->
                <div class="card-hover group stat-box bg-gradient-to-br from-green-50 to-green-100 p-8 rounded-2xl shadow-lg border-l-4 border-green-500 relative">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-green-700 text-sm font-bold uppercase tracking-wide">Pembelian</p>
                            <p class="text-5xl font-black text-green-900 mt-3">{{ $stats['purchases'] ?? 0 }}</p>
                            <p class="text-green-600 text-xs mt-2">🛍️ Perlengkapan lengkap!</p>
                        </div>
                        <div class="icon-box w-20 h-20 bg-white rounded-xl shadow-lg">
                            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Spent Stat -->
                <div class="card-hover group stat-box bg-gradient-to-br from-purple-50 to-purple-100 p-8 rounded-2xl shadow-lg border-l-4 border-purple-500 relative">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-purple-700 text-sm font-bold uppercase tracking-wide">Total Belanja</p>
                            <p class="text-3xl font-black text-purple-900 mt-3">Rp {{ number_format($stats['total_spent'] ?? 0, 0, ',', '.') }}</p>
                            <p class="text-purple-600 text-xs mt-2">💰 Investasi terbaik!</p>
                        </div>
                        <div class="icon-box w-20 h-20 bg-white rounded-xl shadow-lg">
                            <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Events Highlight -->
    <section class="py-24 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-16">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-5xl">🔥</span>
                    <h2 class="text-5xl font-black text-gray-900">Event Mendatang</h2>
                </div>
                <p class="text-xl text-gray-600 max-w-2xl">Jangan lewatkan event-event seru yang akan datang. Daftar sekarang dan raih pengalaman luar biasa!</p>
            </div>

            @php
                $upcomingEvents = \App\Models\Event::where('event_date', '>', now())
                    ->orderBy('event_date', 'asc')
                    ->limit(3)
                    ->get();
            @endphp

            @if($upcomingEvents->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                    @foreach($upcomingEvents as $event)
                        <div class="card-hover group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl border border-gray-100">
                            <!-- Image/Placeholder -->
                            <div class="relative h-56 bg-gradient-to-br from-red-500 via-orange-500 to-yellow-500 flex items-center justify-center overflow-hidden">
                                <svg class="w-24 h-24 text-white opacity-40 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <div class="absolute top-4 right-4 bg-red-600 text-white px-4 py-2 rounded-full text-xs font-bold">MENDATANG</div>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-8">
                                <div class="mb-4">
                                    <h3 class="text-2xl font-bold text-gray-900 mb-2 line-clamp-2">{{ $event->name }}</h3>
                                    <p class="text-gray-600 line-clamp-2 text-sm">{{ $event->description }}</p>
                                </div>
                                
                                <!-- Event Details -->
                                <div class="space-y-3 mb-6 pb-6 border-b border-gray-200">
                                    <div class="flex items-center text-gray-700">
                                        <span class="text-xl mr-3">📅</span>
                                        <span class="font-semibold">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-700">
                                        <span class="text-xl mr-3">🕐</span>
                                        <span class="font-semibold">{{ \Carbon\Carbon::parse($event->event_date)->format('H:i') }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-700">
                                        <span class="text-xl mr-3">📍</span>
                                        <span class="font-semibold">{{ $event->location }}</span>
                                    </div>
                                </div>

                                <!-- CTA Button -->
                                <a href="{{ route('user.events') }}" class="block w-full bg-gradient-to-r from-red-600 to-red-700 text-white py-3 px-4 rounded-lg font-bold hover:shadow-lg transition-all duration-300 text-center transform hover:scale-105">
                                    Lihat Detail & Daftar
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center">
                    <a href="{{ route('user.events') }}" class="inline-block bg-gray-900 text-white hover:bg-gray-800 px-10 py-4 rounded-xl font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                        📋 Lihat Semua Event
                    </a>
                </div>
            @else
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-lg p-12 text-center border-l-4 border-blue-500">
                    <svg class="w-16 h-16 text-blue-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Event Mendatang</h3>
                    <p class="text-gray-600">Pantau terus untuk event-event seru berikutnya!</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-16">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-5xl">🛍️</span>
                    <h2 class="text-5xl font-black text-gray-900">Produk Terlaris</h2>
                </div>
                <p class="text-xl text-gray-600">Perlengkapan berkualitas untuk meningkatkan performa Anda</p>
            </div>

            @php
                $products = \App\Models\Product::orderBy('created_at', 'desc')->limit(4)->get();
            @endphp

            @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                    @foreach($products as $product)
                        <div class="card-hover group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl border border-gray-100">
                            <!-- Product Image -->
                            <div class="relative h-48 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center overflow-hidden group-hover:from-blue-500 group-hover:to-purple-600 transition-all duration-300">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <svg class="w-16 h-16 text-white opacity-40 group-hover:scale-120 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                @endif
                                
                                <!-- Stock Badge -->
                                <div class="absolute top-4 right-4 bg-white text-gray-900 px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                    @if($product->stock > 0)
                                        ✓ {{ $product->stock }} Stok
                                    @else
                                        HABIS
                                    @endif
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="p-5">
                                <h3 class="font-bold text-gray-900 line-clamp-2 mb-2 group-hover:text-red-600 transition-colors">{{ $product->name }}</h3>
                                <p class="text-gray-600 text-sm line-clamp-2 mb-4">{{ $product->description }}</p>
                                
                                <!-- Price -->
                                <div class="flex items-center justify-between mb-4">
                                    <p class="text-3xl font-black text-red-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>

                                <!-- Action Button -->
                                @if($product->stock > 0)
                                    <form method="POST" action="{{ route('user.marketplace.buy', $product->id) }}">
                                        @csrf
                                        <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-red-700 text-white py-3 px-4 rounded-lg font-bold hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                            🛒 Beli Sekarang
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="w-full bg-gray-300 text-gray-500 py-3 px-4 rounded-lg font-bold cursor-not-allowed">
                                        Stok Habis
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center">
                    <a href="{{ route('user.marketplace') }}" class="inline-block bg-gray-900 text-white hover:bg-gray-800 px-10 py-4 rounded-xl font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                        🛍️ Jelajahi Semua Produk
                    </a>
                </div>
            @else
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl shadow-lg p-12 text-center border-l-4 border-gray-400">
                    <p class="text-gray-600 text-lg">Marketplace sedang dipersiapkan</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Quick Access Menu -->
    <section class="py-24 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-16">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-5xl">⚡</span>
                    <h2 class="text-5xl font-black text-gray-900">Akses Cepat</h2>
                </div>
                <p class="text-xl text-gray-600">Navigasi mudah ke semua fitur Punk Football</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Events -->
                <a href="{{ route('user.events') }}" class="card-hover group bg-gradient-to-br from-red-50 to-orange-50 p-8 rounded-2xl shadow-lg border-2 border-red-200 hover:border-red-400 text-center">
                    <div class="w-20 h-20 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-125 group-hover:rotate-12 transition-all duration-300">
                        <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Event Saya</h3>
                    <p class="text-gray-600 text-sm">Kelola event yang Anda ikuti</p>
                    <p class="text-red-600 font-bold mt-4">{{ $stats['events_joined'] }} event →</p>
                </a>

                <!-- Tickets -->
                <a href="{{ route('user.tickets') }}" class="card-hover group bg-gradient-to-br from-blue-50 to-indigo-50 p-8 rounded-2xl shadow-lg border-2 border-blue-200 hover:border-blue-400 text-center">
                    <div class="w-20 h-20 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-125 group-hover:rotate-12 transition-all duration-300">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m-4 0v2m4 0a1 1 0 11-2 0 1 1 0 012 0zm0 4a1 1 0 11-2 0 1 1 0 012 0m0 4a1 1 0 11-2 0 1 1 0 012 0m4-8v2m0 4v2m0-12h2a2 2 0 012 2v12a2 2 0 01-2 2h-2m0 0H7a2 2 0 01-2-2V7a2 2 0 012-2h2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v2"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Tiket Saya</h3>
                    <p class="text-gray-600 text-sm">Lihat tiket event Anda</p>
                    <p class="text-blue-600 font-bold mt-4">{{ $stats['tickets'] }} tiket →</p>
                </a>

                <!-- Marketplace -->
                <a href="{{ route('user.marketplace') }}" class="card-hover group bg-gradient-to-br from-green-50 to-emerald-50 p-8 rounded-2xl shadow-lg border-2 border-green-200 hover:border-green-400 text-center">
                    <div class="w-20 h-20 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-125 group-hover:rotate-12 transition-all duration-300">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Marketplace</h3>
                    <p class="text-gray-600 text-sm">Belanja perlengkapan terbaik</p>
                    <p class="text-green-600 font-bold mt-4">{{ $stats['purchases'] }} pembelian →</p>
                </a>

                <!-- Profile -->
                <a href="{{ route('user.profile') }}" class="card-hover group bg-gradient-to-br from-purple-50 to-pink-50 p-8 rounded-2xl shadow-lg border-2 border-purple-200 hover:border-purple-400 text-center">
                    <div class="w-20 h-20 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-125 group-hover:rotate-12 transition-all duration-300">
                        <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Profil Saya</h3>
                    <p class="text-gray-600 text-sm">Kelola akun dan data pribadi</p>
                    <p class="text-purple-600 font-bold mt-4">{{ auth()->user()->name }} →</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div>
                    <h3 class="text-3xl font-black mb-4 bg-gradient-to-r from-red-500 to-orange-500 bg-clip-text text-transparent">Punk Football</h3>
                    <p class="text-gray-400">Platform terpercaya untuk semua kebutuhan sepak bola Anda. Tingkatkan performa dengan bergabung bersama ribuan pemain lainnya.</p>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-6">Fitur Utama</h4>
                    <ul class="space-y-3 text-gray-400 text-sm">
                        <li><a href="{{ route('user.events') }}" class="hover:text-white transition">⚽ Event Sepak Bola</a></li>
                        <li><a href="{{ route('user.marketplace') }}" class="hover:text-white transition">🛍️ Marketplace</a></li>
                        <li><a href="{{ route('user.tickets') }}" class="hover:text-white transition">🎫 Tiket Pertandingan</a></li>
                        <li><a href="{{ route('user.profile') }}" class="hover:text-white transition">👤 Profil</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-6">Dukungan</h4>
                    <ul class="space-y-3 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white transition">💬 Hubungi Kami</a></li>
                        <li><a href="#" class="hover:text-white transition">❓ FAQ</a></li>
                        <li><a href="#" class="hover:text-white transition">🔒 Privasi</a></li>
                        <li><a href="#" class="hover:text-white transition">📋 Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-6">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="w-12 h-12 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-red-600 transition-all duration-300 transform hover:scale-110">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-12 h-12 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-red-600 transition-all duration-300 transform hover:scale-110">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v 3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; 2024 Punk Football. Semua hak dilindungi. ⚽</p>
            </div>
        </div>
    </footer>
</body>
</html>
                        <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="card-hover bg-white p-6 rounded-2xl shadow-lg border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Belanja</p>
                            <p class="text-2xl font-black text-gray-900 mt-2">Rp {{ number_format($stats['total_spent'] ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Events -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-16">
                <h2 class="text-4xl font-black text-gray-900 mb-4">Event Mendatang</h2>
                <p class="text-xl text-gray-600">Jangan lewatkan event-event seru kami</p>
            </div>

            @php
                $upcomingEvents = \App\Models\Event::where('event_date', '>', now())
                    ->orderBy('event_date', 'asc')
                    ->limit(3)
                    ->get();
            @endphp

            @if($upcomingEvents->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                    @foreach($upcomingEvents as $event)
                        <div class="card-hover bg-white rounded-2xl overflow-hidden shadow-lg">
                            <div class="h-48 bg-gradient-to-br from-red-500 to-orange-500 flex items-center justify-center">
                                <svg class="w-16 h-16 text-white opacity-50" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-3">
                                    <h3 class="text-xl font-bold text-gray-900 flex-1">{{ $event->name }}</h3>
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold">MENDATANG</span>
                                </div>
                                <p class="text-gray-600 mb-4 line-clamp-2">{{ $event->description }}</p>
                                <div class="space-y-2 mb-6 text-sm text-gray-600">
                                    <p>📅 {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y, H:i') }}</p>
                                    <p>📍 {{ $event->location }}</p>
                                </div>
                                <a href="{{ route('user.events') }}" class="block w-full bg-red-600 text-white py-2 px-4 rounded-lg font-bold hover:bg-red-700 transition text-center">Lihat Detail</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center">
                    <a href="{{ route('user.events') }}" class="inline-block bg-gray-900 text-white hover:bg-gray-800 px-8 py-3 rounded-xl font-bold transition">Lihat Semua Event</a>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Event Mendatang</h3>
                    <p class="text-gray-600 mb-6">Pantau terus untuk event-event seru berikutnya</p>
                    <a href="{{ route('user.events') }}" class="inline-block bg-red-600 text-white hover:bg-red-700 px-8 py-3 rounded-xl font-bold transition">Jelajahi Event</a>
                </div>
            @endif
        </div>
    </section>

    <!-- Recommended Products -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-16">
                <h2 class="text-4xl font-black text-gray-900 mb-4">Produk Terlaris</h2>
                <p class="text-xl text-gray-600">Perlengkapan berkualitas untuk meningkatkan performa Anda</p>
            </div>

            @php
                $products = \App\Models\Product::orderBy('created_at', 'desc')->limit(4)->get();
            @endphp

            @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    @foreach($products as $product)
                        <div class="card-hover bg-gray-50 rounded-2xl overflow-hidden shadow-lg">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-48 w-full object-cover">
                            @else
                                <div class="h-48 bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900 line-clamp-2 mb-2">{{ $product->name }}</h3>
                                <p class="text-gray-600 text-sm line-clamp-2 mb-4">{{ $product->description }}</p>
                                <div class="flex justify-between items-center mb-4">
                                    <p class="text-2xl font-black text-red-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    @if($product->stock > 0)
                                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">{{ $product->stock }} left</span>
                                    @else
                                        <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded">Habis</span>
                                    @endif
                                </div>
                                @if($product->stock > 0)
                                    <form method="POST" action="{{ route('user.marketplace.buy', $product->id) }}">
                                        @csrf
                                        <button type="submit" class="block w-full bg-red-600 text-white py-2 px-4 rounded-lg font-bold hover:bg-red-700 transition text-center text-sm">Beli Sekarang</button>
                                    </form>
                                @else
                                    <button disabled class="block w-full bg-gray-300 text-gray-500 py-2 px-4 rounded-lg font-bold text-sm cursor-not-allowed">Stok Habis</button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center">
                    <a href="{{ route('user.marketplace') }}" class="inline-block bg-gray-900 text-white hover:bg-gray-800 px-8 py-3 rounded-xl font-bold transition">Lihat Semua Produk</a>
                </div>
            @else
                <div class="bg-gray-50 rounded-2xl shadow-lg p-12 text-center">
                    <p class="text-gray-600 text-lg">Marketplace sedang dipersiapkan</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Quick Links -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-16">
                <h2 class="text-4xl font-black text-gray-900 mb-4">Menu Cepat</h2>
                <p class="text-xl text-gray-600">Akses fitur dengan mudah</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('user.events') }}" class="card-hover group bg-white p-8 rounded-2xl shadow-lg text-center border-t-4 border-red-500 hover:border-red-600">
                    <div class="w-16 h-16 bg-red-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Event Saya</h3>
                    <p class="text-gray-600">Kelola event yang Anda ikuti</p>
                </a>

                <a href="{{ route('user.tickets') }}" class="card-hover group bg-white p-8 rounded-2xl shadow-lg text-center border-t-4 border-blue-500 hover:border-blue-600">
                    <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m-4 0v2m4 0a1 1 0 11-2 0 1 1 0 012 0zm0 4a1 1 0 11-2 0 1 1 0 012 0m0 4a1 1 0 11-2 0 1 1 0 012 0m4-8v2m0 4v2m0-12h2a2 2 0 012 2v12a2 2 0 01-2 2h-2m0 0H7a2 2 0 01-2-2V7a2 2 0 012-2h2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v2"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Tiket Saya</h3>
                    <p class="text-gray-600">Lihat tiket event Anda</p>
                </a>

                <a href="{{ route('user.marketplace') }}" class="card-hover group bg-white p-8 rounded-2xl shadow-lg text-center border-t-4 border-green-500 hover:border-green-600">
                    <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Marketplace</h3>
                    <p class="text-gray-600">Belanja perlengkapan sepak bola</p>
                </a>

                <a href="{{ route('user.profile') }}" class="card-hover group bg-white p-8 rounded-2xl shadow-lg text-center border-t-4 border-purple-500 hover:border-purple-600">
                    <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Profil Saya</h3>
                    <p class="text-gray-600">Kelola akun dan data pribadi</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4 text-red-500">Punk Football</h3>
                    <p class="text-gray-400">Platform terpercaya untuk semua kebutuhan sepak bola Anda</p>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Fitur</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="{{ route('user.events') }}" class="hover:text-white transition">Event Sepak Bola</a></li>
                        <li><a href="{{ route('user.marketplace') }}" class="hover:text-white transition">Marketplace</a></li>
                        <li><a href="{{ route('user.tickets') }}" class="hover:text-white transition">Tiket</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Dukungan</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white transition">Hubungi Kami</a></li>
                        <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-white transition">Privasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Ikuti Kami</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-red-600 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-red-600 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v 3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; 2024 Punk Football. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>
</body>
</html>
