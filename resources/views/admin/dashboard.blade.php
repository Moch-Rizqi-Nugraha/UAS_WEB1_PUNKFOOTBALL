@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Hero Section -->
<div class="relative w-full h-screen bg-cover bg-center flex items-center justify-center" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=1200&h=600&fit=crop');">
    <div class="text-center text-white px-4">
        <h1 class="text-5xl md:text-6xl font-bold mb-4">One Team. One Dream</h1>
        <p class="text-lg md:text-xl mb-8 max-w-2xl mx-auto">
            Bersama kami membangun tim profesional yang solid. Dengan dedikasi penuh untuk mencapai prestasi tertinggi dalam setiap kompetisi.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="#" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded font-semibold transition">
                Lihat Sekarang
            </a>
            <a href="#" class="border-2 border-white text-white hover:bg-white hover:text-gray-900 px-8 py-3 rounded font-semibold transition">
                Pelajari Lebih Lanjut
            </a>
        </div>
    </div>
</div>

<!-- About Section -->
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-900">ABOUT US</h2>
        <div class="text-center mb-8">
            <p class="text-gray-700 text-lg leading-relaxed max-w-3xl mx-auto">
                Kami adalah organisasi olahraga yang berkomitmen untuk mengembangkan talenta terbaik. Dengan fasilitas modern dan pelatih berpengalaman, kami menciptakan lingkungan yang mendukung pertumbuhan atlet secara profesional dan personal.
            </p>
        </div>
        <div class="flex flex-wrap justify-center gap-4 mb-8">
            <button class="bg-red-600 text-white px-6 py-2 rounded font-semibold hover:bg-red-700 transition">
                Visi & Misi
            </button>
            <button class="border-2 border-gray-300 text-gray-700 px-6 py-2 rounded font-semibold hover:bg-gray-100 transition">
                Sejarah
            </button>
            <button class="bg-red-600 text-white px-6 py-2 rounded font-semibold hover:bg-red-700 transition">
                Skuad
            </button>
        </div>
    </div>
</section>

<!-- Event Results Section -->
<section class="py-16 bg-gray-100">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-900">EVENT RESULTS</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $events = \App\Models\Event::where('is_active', true)->limit(3)->get();
                if($events->isEmpty()) {
                    $events = collect([
                        (object)['title' => 'Grand Final 2026', 'result' => '3-1', 'team1' => 'Team A', 'team2' => 'Team B', 'date' => now()],
                        (object)['title' => 'Semi Final', 'result' => '2-1', 'team1' => 'Team C', 'team2' => 'Team D', 'date' => now()],
                        (object)['title' => 'Quarter Final', 'result' => '4-0', 'team1' => 'Team E', 'team2' => 'Team F', 'date' => now()],
                    ]);
                }
            @endphp
            @foreach($events as $event)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gray-800 text-white p-4 text-center">
                    <h3 class="font-bold text-lg">{{ $event->title ?? 'Event' }}</h3>
                    <p class="text-sm text-gray-400">{{ isset($event->date) ? $event->date->format('d M Y') : now()->format('d M Y') }}</p>
                </div>
                <div class="p-6 text-center">
                    <div class="text-5xl font-bold text-red-600 mb-4">{{ $event->result ?? '0-0' }}</div>
                    <div class="text-gray-600 text-sm">
                        <p class="mb-2">{{ $event->team1 ?? 'Team 1' }} vs {{ $event->team2 ?? 'Team 2' }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Our Teams Section -->
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-900">OUR TEAMS</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="flex flex-col items-center">
                <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=500&fit=crop" alt="Player" class="w-full max-w-sm rounded-lg shadow-lg mb-6 object-cover">
                <h3 class="text-2xl font-bold text-gray-900">John Doe</h3>
            </div>
            <div class="flex flex-col justify-center">
                <div class="space-y-4">
                    <div class="border-l-4 border-red-600 pl-4">
                        <p class="font-semibold text-gray-900">Posisi</p>
                        <p class="text-gray-700">Forward / Striker</p>
                    </div>
                    <div class="border-l-4 border-red-600 pl-4">
                        <p class="font-semibold text-gray-900">Nomor Punggung</p>
                        <p class="text-gray-700">7</p>
                    </div>
                    <div class="border-l-4 border-red-600 pl-4">
                        <p class="font-semibold text-gray-900">Tinggi Badan</p>
                        <p class="text-gray-700">185 cm</p>
                    </div>
                    <div class="border-l-4 border-red-600 pl-4">
                        <p class="font-semibold text-gray-900">Berat Badan</p>
                        <p class="text-gray-700">82 kg</p>
                    </div>
                    <div class="mt-6">
                        <a href="#" class="bg-red-600 text-white px-8 py-2 rounded font-semibold hover:bg-red-700 transition inline-block">
                            View Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest News Section -->
<section class="py-16 bg-gray-100">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-900">LATEST NEWS</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $articles = \App\Models\Article::where('is_active', true)->latest()->limit(3)->get();
                if($articles->isEmpty()) {
                    $articles = collect([
                        (object)['title' => 'Persiapan Menghadapi Turnamen Internasional', 'excerpt' => 'Tim kami telah memulai persiapan intensif untuk menghadapi kompetisi tingkat internasional yang akan datang.', 'image' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=500&h=300&fit=crop', 'created_at' => now()],
                        (object)['title' => 'Penghargaan untuk Pemain Terbaik Musim Ini', 'excerpt' => 'Salah satu pemain kami meraih penghargaan pemain terbaik berkat performa luar biasa sepanjang musim.', 'image' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=500&h=300&fit=crop', 'created_at' => now()],
                        (object)['title' => 'Pembukaan Fasilitas Latihan Baru', 'excerpt' => 'Fasilitas pelatihan state-of-the-art telah dibuka untuk mendukung pengembangan atlet kami.', 'image' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=500&h=300&fit=crop', 'created_at' => now()],
                    ]);
                }
            @endphp
            @foreach($articles as $article)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                <img src="{{ $article->image ?? 'https://via.placeholder.com/500x300' }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-900 mb-2 line-clamp-2">{{ $article->title ?? 'News Title' }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $article->excerpt ?? $article->description ?? 'News excerpt' }}</p>
                    <p class="text-xs text-gray-500">{{ isset($article->created_at) ? $article->created_at->format('d M Y') : now()->format('d M Y') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-16 bg-gradient-to-r from-gray-800 to-gray-900 text-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold mb-2">{{ \App\Models\User::count() }}</div>
                <p class="text-gray-300">Total Users</p>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">{{ \App\Models\Event::count() }}</div>
                <p class="text-gray-300">Events</p>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">{{ \App\Models\Article::count() }}</div>
                <p class="text-gray-300">Articles</p>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">{{ \App\Models\Gallery::count() }}</div>
                <p class="text-gray-300">Gallery Items</p>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-12">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <div>
                <h4 class="font-bold text-lg mb-4">ABOUT</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="#" class="hover:text-white transition">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-white transition">Sejarah</a></li>
                    <li><a href="#" class="hover:text-white transition">Visi & Misi</a></li>
                    <li><a href="#" class="hover:text-white transition">Tim Manajemen</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-4">INFORMATION</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="#" class="hover:text-white transition">Event</a></li>
                    <li><a href="#" class="hover:text-white transition">Jadwal</a></li>
                    <li><a href="#" class="hover:text-white transition">Berita</a></li>
                    <li><a href="#" class="hover:text-white transition">Gallery</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-4">SERVICES</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="#" class="hover:text-white transition">Ticketing</a></li>
                    <li><a href="#" class="hover:text-white transition">Merchandise</a></li>
                    <li><a href="#" class="hover:text-white transition">Sponsorship</a></li>
                    <li><a href="#" class="hover:text-white transition">Partnership</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-4">GALLERY</h4>
                <div class="grid grid-cols-2 gap-2">
                    @for($i = 1; $i <= 4; $i++)
                    <img src="https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=100&h=100&fit=crop" alt="Gallery" class="rounded w-full h-20 object-cover">
                    @endfor
                </div>
            </div>
        </div>
        <div class="border-t border-gray-800 pt-8">
            <div class="flex justify-center items-center gap-6 mb-4">
                <a href="#" class="text-gray-400 hover:text-white transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2s9 5 20 5a9.5 9.5 0 00-9-5.5c4.75 2.25 9 5 9 5z"/></svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16.5 6.5h-9v11h9v-11z" fill="white"/><polygon points="13.5,10.5 13.5,15.5 10.5,13 13.5,10.5" fill="white"/></svg>
                </a>
            </div>
            <div class="text-center text-gray-400 text-sm">
                <p>&copy; 2026 Punk Football. All rights reserved.</p>
                <p class="mt-2">Designed with passion for the beautiful game</p>
            </div>
        </div>
    </div>
</footer>

@endsection