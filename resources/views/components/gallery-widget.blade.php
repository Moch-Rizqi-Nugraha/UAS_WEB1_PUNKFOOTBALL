<!-- Gallery Component -->
<div class="bg-white rounded-lg shadow-lg p-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-6 transition-all duration-500 hover:text-blue-600">Galeri</h2>
    
    @if($galleries->count())
        <style>
            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateX(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            
            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(20px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            
            .gallery-card-animation {
                animation: slideInRight 0.5s ease-out forwards;
                opacity: 0;
            }
            
            .gallery-card-animation:nth-child(odd) {
                animation: slideIn 0.5s ease-out forwards;
            }
            
            .gallery-card-animation:nth-child(1) { animation-delay: 0.1s; }
            .gallery-card-animation:nth-child(2) { animation-delay: 0.15s; }
            .gallery-card-animation:nth-child(3) { animation-delay: 0.2s; }
            .gallery-card-animation:nth-child(4) { animation-delay: 0.25s; }
            .gallery-card-animation:nth-child(5) { animation-delay: 0.3s; }
            .gallery-card-animation:nth-child(6) { animation-delay: 0.35s; }
            .gallery-card-animation:nth-child(7) { animation-delay: 0.4s; }
            .gallery-card-animation:nth-child(8) { animation-delay: 0.45s; }
        </style>
        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">
            @foreach($galleries as $gallery)
                <div class="gallery-card-animation group relative overflow-hidden rounded-lg bg-gray-200 aspect-square cursor-pointer hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1" 
                     onclick="openGalleryModal({{ $gallery->id }}, '{{ addslashes($gallery->title) }}', '{{ asset('storage/' . $gallery->image) }}', '{{ addslashes($gallery->description ?? '') }}')">
                    
                    <!-- Image -->
                    <img src="{{ asset('storage/' . $gallery->image) }}" 
                         alt="{{ $gallery->image_alt ?? $gallery->title }}" 
                         class="w-full h-full object-cover group-hover:scale-120 transition-transform duration-700 ease-out">
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-500 flex items-center justify-center">
                        <div class="text-center transform scale-90 group-hover:scale-110 transition-transform duration-500">
                            <svg class="w-12 h-12 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Title Overlay at Bottom -->
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black via-black/40 to-transparent p-3 transform translate-y-1 group-hover:translate-y-0 transition-transform duration-300">
                        <h3 class="text-white font-semibold text-sm truncate group-hover:text-base transition-all duration-300">{{ $gallery->title }}</h3>
                        @if($gallery->category)
                            <p class="text-gray-300 text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-500">{{ $gallery->category }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- View All Button if more galleries exist -->
        @if($galleries->count() >= 8)
            <div class="text-center">
                <a href="{{ route('galleries.index') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Lihat Selengkapnya
                </a>
            </div>
        @endif
    @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <p class="text-gray-500 text-lg">Belum ada galeri</p>
        </div>
    @endif
</div>

<!-- Modal for viewing gallery images -->
<div id="galleryModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
     onclick="if(event.target.id === 'galleryModal') closeGalleryModal()">
    <div class="bg-white rounded-lg max-w-2xl w-full overflow-hidden shadow-2xl">
        <!-- Header -->
        <div class="flex justify-between items-center p-6 border-b">
            <h2 id="modalTitle" class="text-2xl font-bold text-gray-900"></h2>
            <button onclick="closeGalleryModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Content -->
        <div class="p-6">
            <img id="modalImage" src="" alt="" class="w-full h-auto rounded-lg mb-4">
            <p id="modalDescription" class="text-gray-700 text-base"></p>
        </div>
    </div>
</div>

<script>
function openGalleryModal(id, title, image, description) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalImage').src = image;
    document.getElementById('modalDescription').textContent = description || 'Tidak ada deskripsi';
    document.getElementById('galleryModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeGalleryModal() {
    document.getElementById('galleryModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeGalleryModal();
    }
});
</script>
