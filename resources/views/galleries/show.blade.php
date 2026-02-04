<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $gallery->title }} - Galeri - Punk Football</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    @include('layouts.navigation')

    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Breadcrumb -->
            <div class="mb-6">
                <a href="{{ route('galleries.index') }}" class="text-blue-600 hover:text-blue-700">← Kembali ke Galeri</a>
            </div>

            <!-- Main Image -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                <img src="{{ asset('storage/' . $gallery->image) }}" 
                     alt="{{ $gallery->image_alt ?? $gallery->title }}" 
                     class="w-full h-auto max-h-96 object-cover">
            </div>

            <!-- Gallery Information -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="mb-6">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $gallery->title }}</h1>
                    <div class="flex items-center gap-4 text-gray-600">
                        @if($gallery->category)
                            <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $gallery->category }}
                            </span>
                        @endif
                        <span>{{ $gallery->created_at->format('d F Y') }}</span>
                    </div>
                </div>

                @if($gallery->description)
                    <div class="prose max-w-none">
                        <p class="text-gray-700 text-base leading-relaxed">{{ $gallery->description }}</p>
                    </div>
                @endif

                <!-- Metadata -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Dibuat</span>
                            <p class="font-medium text-gray-900">{{ $gallery->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Diperbarui</span>
                            <p class="font-medium text-gray-900">{{ $gallery->updated_at->format('d M Y H:i') }}</p>
                        </div>
                        @if($gallery->creator)
                            <div>
                                <span class="text-gray-500">Oleh</span>
                                <p class="font-medium text-gray-900">{{ $gallery->creator->name }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Related Galleries -->
            @if($related->count())
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Galeri Terkait</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($related as $relatedGallery)
                            <a href="{{ route('galleries.show', $relatedGallery) }}" 
                               class="group relative overflow-hidden rounded-lg bg-gray-200 aspect-square hover:shadow-lg transition-all">
                                
                                <img src="{{ asset('storage/' . $relatedGallery->image) }}" 
                                     alt="{{ $relatedGallery->image_alt ?? $relatedGallery->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                
                                <div class="absolute bottom-0 left-0 right-0 p-3">
                                    <h3 class="text-white font-semibold text-sm group-hover:text-base transition-all truncate">{{ $relatedGallery->title }}</h3>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12 mt-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center">
                <p>&copy; 2026 Punk Football. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
