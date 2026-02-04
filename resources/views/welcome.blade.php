<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Punk Football - Platform Sepak Bola Modern</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }
            .animate-float { animation: float 6s ease-in-out infinite; }

            @keyframes pulse-ring {
                0% {
                    box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
                }
                70% {
                    box-shadow: 0 0 0 20px rgba(239, 68, 68, 0);
                }
                100% {
                    box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
                }
            }

            @keyframes rotate-border {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            @keyframes bounce-slow {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-15px); }
            }

            .coach-image {
                animation: bounce-slow 3s ease-in-out infinite;
            }

            .coach-image-red {
                box-shadow: 0 0 20px rgba(239, 68, 68, 0.5);
                animation: pulse-ring 2s infinite, bounce-slow 3s ease-in-out infinite;
            }

            .coach-image-blue {
                box-shadow: 0 0 20px rgba(74, 144, 226, 0.5);
                animation: pulse-ring 2s infinite 0.3s, bounce-slow 3s ease-in-out infinite 0.3s;
            }

            .coach-image-green {
                box-shadow: 0 0 20px rgba(30, 203, 127, 0.5);
                animation: pulse-ring 2s infinite 0.6s, bounce-slow 3s ease-in-out infinite 0.6s;
            }

            .coach-card {
                position: relative;
                overflow: hidden;
            }

            .coach-card::before {
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

            .coach-image-wrapper {
                position: relative;
                display: inline-block;
                margin-bottom: 1rem;
            }

            .coach-badge {
                position: absolute;
                bottom: 0;
                right: 0;
                background: linear-gradient(135deg, #ff6b6b, #ffa500);
                color: white;
                padding: 8px 12px;
                border-radius: 50%;
                width: 50px;
                height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 20px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                animation: scale-pulse 2s ease-in-out infinite;
            }

            @keyframes scale-pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.15); }
            }
        </style>
    </head>
    <body>
        <!-- Navigation -->
        <nav class="bg-gray-900 shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-white text-xl font-bold">Punk Football</h1>
                        <div class="hidden md:block ml-10">
                            <div class="flex items-baseline space-x-4">
                                <a href="#home" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">Beranda</a>
                                <a href="#events" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">Event</a>
                                <a href="#coaches" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">Pelatih</a>
                                <a href="#marketplace" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">Marketplace</a>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-300 hover:text-white text-sm font-medium">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-300 hover:text-white text-sm font-medium">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-red-600 text-white hover:bg-red-700 px-4 py-2 rounded-lg text-sm font-medium">Daftar</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section id="home" class="relative w-full h-screen bg-gradient-to-br from-gray-900 via-slate-800 to-black text-white flex items-center justify-center overflow-hidden">
            <div class="absolute top-0 left-0 w-96 h-96 bg-red-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
            
            <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
                <div class="mb-6 inline-block">
                    <span class="bg-red-600 text-white px-4 py-2 rounded-full text-sm font-bold">⚽ Platform Terpercaya #1</span>
                </div>
                <h1 class="text-5xl md:text-7xl font-black mb-6">
                    <span class="bg-gradient-to-r from-red-500 via-orange-500 to-yellow-500 bg-clip-text text-transparent">Platform Sepak Bola</span>
                    <span class="block text-white">Modern</span>
                </h1>
                <p class="text-lg md:text-xl mb-10 text-gray-300">Temukan event, pelatih profesional, dan perlengkapan terbaik untuk meningkatkan permainan Anda</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('events.index') }}" class="bg-white text-gray-900 hover:bg-gray-100 px-8 py-4 rounded-xl font-bold text-lg transition duration-300 transform hover:scale-105">Jelajahi Event</a>
                    <a href="{{ route('marketplace.index') }}" class="border-2 border-white text-white hover:bg-red-600 px-8 py-4 rounded-xl font-bold text-lg transition duration-300 transform hover:scale-105">Belanja Sekarang</a>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-24 bg-white">
            <div class="max-w-6xl mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">Mengapa Memilih Punk Football?</h2>
                    <p class="text-xl text-gray-600">Platform terpercaya dengan fitur lengkap untuk semua kebutuhan sepak bola Anda</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 border-t-4 border-red-500">
                        <div class="w-16 h-16 bg-red-100 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Event Sepak Bola</h3>
                        <p class="text-gray-600">Temukan dan ikuti berbagai event sepak bola dari turnamen lokal hingga internasional</p>
                    </div>
                    <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 border-t-4 border-blue-500">
                        <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Pelatih Profesional</h3>
                        <p class="text-gray-600">Dapatkan bimbingan dari pelatih berpengalaman untuk meningkatkan skill sepak bola Anda</p>
                    </div>
                    <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 border-t-4 border-green-500">
                        <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Marketplace</h3>
                        <p class="text-gray-600">Belanja perlengkapan sepak bola berkualitas dengan harga terbaik dari brand ternama</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Events Section -->
        <section id="events" class="py-24 bg-gray-50">
            <div class="max-w-6xl mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">Event Sepak Bola Terdekat</h2>
                    <p class="text-xl text-gray-600">Bergabunglah dalam event-event seru kami</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition duration-300">
                        <div class="bg-gradient-to-r from-red-500 to-orange-500 text-white px-4 py-2 rounded-lg text-sm font-bold inline-block mb-4">Turnamen</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Liga Kampung Cup 2024</h3>
                        <p class="text-gray-600 mb-4">Turnamen sepak bola antar kampung dengan hadiah total Rp 5.000.000</p>
                        <div class="space-y-2 text-sm text-gray-600 mb-6">
                            <p>📅 15 Desember 2024</p>
                            <p>📍 Lapangan ABC</p>
                        </div>
                        <a href="{{ route('events.index') }}" class="block w-full bg-red-600 text-white py-2 px-4 rounded-lg font-bold hover:bg-red-700 transition text-center">Daftar Sekarang</a>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition duration-300">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-500 text-white px-4 py-2 rounded-lg text-sm font-bold inline-block mb-4">Pelatihan</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Bootcamp Teknik Dasar</h3>
                        <p class="text-gray-600 mb-4">Pelatihan intensif teknik dasar sepak bola untuk pemula hingga menengah</p>
                        <div class="space-y-2 text-sm text-gray-600 mb-6">
                            <p>📅 20 Desember 2024</p>
                            <p>📍 Stadion XYZ</p>
                        </div>
                        <a href="{{ route('events.index') }}" class="block w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-bold hover:bg-blue-700 transition text-center">Daftar Sekarang</a>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition duration-300">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-4 py-2 rounded-lg text-sm font-bold inline-block mb-4">Friendly Match</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Pertandingan Persahabatan</h3>
                        <p class="text-gray-600 mb-4">Jadwal pertandingan persahabatan untuk mengasah kemampuan tim Anda</p>
                        <div class="space-y-2 text-sm text-gray-600 mb-6">
                            <p>📅 25 Desember 2024</p>
                            <p>📍 Lapangan DEF</p>
                        </div>
                        <a href="{{ route('events.index') }}" class="block w-full bg-green-600 text-white py-2 px-4 rounded-lg font-bold hover:bg-green-700 transition text-center">Daftar Sekarang</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Coaches Section -->
        <section id="coaches" class="py-24 bg-white">
            <div class="max-w-6xl mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">Pelatih Profesional</h2>
                    <p class="text-xl text-gray-600">Belajar dari para ahli di bidangnya</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 text-center coach-card">
                        <div class="coach-image-wrapper">
                            <img src="https://ui-avatars.com/api/?name=Ahmad+Coach&background=EF4444&color=fff&size=200&font-size=80&bold=true" alt="Coach Ahmad" class="w-32 h-32 rounded-full mx-auto border-4 border-red-500 coach-image-red">
                            <div class="coach-badge">🏆</div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Coach Ahmad</h3>
                        <p class="text-red-600 font-semibold mb-3">Bersertifikat Internasional</p>
                        <p class="text-gray-600 mb-4">Pengalaman 10+ tahun di liga profesional</p>
                        <div class="flex justify-center space-x-2 mb-4">
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">⭐ 4.9</span>
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">50+ Siswa</span>
                        </div>
                        <a href="#" class="block w-full bg-red-600 text-white py-2 px-4 rounded-lg font-bold hover:bg-red-700 transition">Hubungi</a>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 text-center coach-card">
                        <div class="coach-image-wrapper">
                            <img src="https://ui-avatars.com/api/?name=Budi+Coach&background=4A90E2&color=fff&size=200&font-size=80&bold=true" alt="Coach Budi" class="w-32 h-32 rounded-full mx-auto border-4 border-blue-500 coach-image-blue">
                            <div class="coach-badge">⚡</div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Coach Budi</h3>
                        <p class="text-blue-600 font-semibold mb-3">Spesialis Teknik & Taktik</p>
                        <p class="text-gray-600 mb-4">Ahli teknik dasar dan taktik permainan</p>
                        <div class="flex justify-center space-x-2 mb-4">
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">⭐ 4.8</span>
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">75+ Siswa</span>
                        </div>
                        <a href="#" class="block w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-bold hover:bg-blue-700 transition">Hubungi</a>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 text-center coach-card">
                        <div class="coach-image-wrapper">
                            <img src="https://ui-avatars.com/api/?name=Cici+Coach&background=1ECB7F&color=fff&size=200&font-size=80&bold=true" alt="Coach Cici" class="w-32 h-32 rounded-full mx-auto border-4 border-green-500 coach-image-green">
                            <div class="coach-badge">💪</div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Coach Cici</h3>
                        <p class="text-green-600 font-semibold mb-3">Spesialis Fitness</p>
                        <p class="text-gray-600 mb-4">Ahli dalam fitness dan conditioning atlet</p>
                        <div class="flex justify-center space-x-2 mb-4">
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">⭐ 5.0</span>
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">30+ Siswa</span>
                        </div>
                        <a href="#" class="block w-full bg-green-600 text-white py-2 px-4 rounded-lg font-bold hover:bg-green-700 transition">Hubungi</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Marketplace Section -->
        <section id="marketplace" class="py-24 bg-gray-900 text-white">
            <div class="max-w-6xl mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-black mb-6">Marketplace Perlengkapan</h2>
                    <p class="text-xl text-gray-300">Produk berkualitas dari brand terpercaya</p>
                </div>
                @php
                    $products = \App\Models\Product::orderBy('created_at', 'desc')->limit(4)->get();
                @endphp
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        @foreach($products as $product)
                            <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition duration-300">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-48 w-full object-cover">
                                @else
                                    <div class="h-48 bg-gradient-to-br from-red-500 to-orange-500 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="p-4">
                                    <h3 class="text-lg font-bold mb-2 line-clamp-2">{{ $product->name }}</h3>
                                    <p class="text-gray-300 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>
                                    <div class="flex justify-between items-center mb-4">
                                        <p class="text-2xl font-bold text-red-400">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                        @if($product->stock > 0)
                                            <span class="text-xs bg-green-600 px-2 py-1 rounded">Stok: {{ $product->stock }}</span>
                                        @else
                                            <span class="text-xs bg-red-600 px-2 py-1 rounded">Habis</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('marketplace.index') }}" class="block w-full bg-red-600 text-white py-2 px-4 rounded-lg font-bold hover:bg-red-700 transition text-center text-sm">Beli</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-400 text-lg mb-6">Belum ada produk di marketplace</p>
                        <a href="{{ route('marketplace.index') }}" class="inline-block bg-red-600 text-white hover:bg-red-700 px-8 py-3 rounded-xl font-bold transition">Jelajahi Marketplace</a>
                    </div>
                @endif
                <div class="text-center mt-12">
                    <a href="{{ route('marketplace.index') }}" class="inline-block bg-white text-gray-900 hover:bg-gray-100 px-8 py-3 rounded-xl font-bold text-lg transition">Lihat Semua Produk</a>
                </div>
            </div>
        </section>

        <!-- Gallery Section -->
        <section id="gallery" class="py-24 bg-white">
            <div class="max-w-6xl mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">Galeri Acara Kami</h2>
                    <p class="text-xl text-gray-600">Momen-momen terbaik dari berbagai acara</p>
                </div>
                @php
                    $galleries = \App\Models\Gallery::active()->orderBy('order')->orderBy('created_at', 'desc')->limit(8)->get();
                @endphp
                @if($galleries->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-12">
                        @foreach($galleries as $gallery)
                            <a href="{{ route('galleries.show', $gallery) }}" class="group relative overflow-hidden rounded-xl bg-gray-300 aspect-square hover:shadow-xl transition duration-300">
                                <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-6 group-hover:translate-y-0 transition-transform duration-300">
                                    <h3 class="text-white font-bold line-clamp-2">{{ $gallery->title }}</h3>
                                    @if($gallery->category)
                                        <p class="text-gray-200 text-sm">{{ $gallery->category }}</p>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="text-center">
                        <a href="{{ route('galleries.index') }}" class="inline-block bg-gray-900 text-white hover:bg-gray-800 px-8 py-3 rounded-xl font-bold transition">Lihat Semua Galeri</a>
                    </div>
                @endif
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-6xl mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <div>
                        <h3 class="text-2xl font-bold mb-4 text-red-500">Punk Football</h3>
                        <p class="text-gray-400">Platform terpercaya untuk semua kebutuhan sepak bola Anda</p>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold mb-4">Fitur</h4>
                        <ul class="space-y-2 text-gray-400 text-sm">
                            <li><a href="#events" class="hover:text-white transition">Event Sepak Bola</a></li>
                            <li><a href="#coaches" class="hover:text-white transition">Pelatih Profesional</a></li>
                            <li><a href="#gallery" class="hover:text-white transition">Galeri</a></li>
                            <li><a href="#marketplace" class="hover:text-white transition">Marketplace</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold mb-4">Dukungan</h4>
                        <ul class="space-y-2 text-gray-400 text-sm">
                            <li><a href="#" class="hover:text-white transition">Hubungi Kami</a></li>
                            <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                            <li><a href="#" class="hover:text-white transition">Privasi</a></li>
                            <li><a href="#" class="hover:text-white transition">Syarat & Ketentuan</a></li>
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
