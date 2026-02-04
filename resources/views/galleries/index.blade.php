<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Galeri - Punk Football</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    @include('layouts.navigation')

    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Galeri Punk Football</h1>
                <p class="text-gray-600">Koleksi foto dan momen penting dari acara-acara kami</p>
            </div>

            <!-- Filter Section -->
            <div class="mb-8">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('galleries.index') }}" 
                       class="px-4 py-2 rounded-full transition-all {{ !request('category') ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:border-blue-600' }}">
                        Semua
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('galleries.category', $cat) }}" 
                           class="px-4 py-2 rounded-full transition-all {{ request('category') == $cat ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:border-blue-600' }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Gallery Grid -->
            @if($galleries->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
                    @foreach($galleries as $gallery)
                        <a href="{{ route('galleries.show', $gallery) }}" 
                           class="group relative overflow-hidden rounded-lg bg-gray-200 aspect-square hover:shadow-xl transition-all duration-300">
                            
                            <!-- Image -->
                            <img src="{{ asset('storage/' . $gallery->image) }}" 
                                 alt="{{ $gallery->image_alt ?? $gallery->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent group-hover:via-black/40 transition-all duration-300"></div>
                            
                            <!-- Content -->
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <h3 class="text-white font-bold text-base group-hover:text-lg transition-all">{{ $gallery->title }}</h3>
                                @if($gallery->category)
                                    <p class="text-gray-200 text-sm">{{ $gallery->category }}</p>
                                @endif
                            </div>

                            <!-- Hover Icon -->
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $galleries->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada galeri</h3>
                    <p class="text-gray-600">Galeri akan ditampilkan di sini. Silakan periksa kembali nanti.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center">
                <p>&copy; 2026 Punk Football. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
