<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of active galleries.
     */
    public function index()
    {
        $galleries = Gallery::active()
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        $categories = Gallery::active()
            ->distinct('category')
            ->pluck('category')
            ->filter()
            ->values();

        return view('galleries.index', compact('galleries', 'categories'));
    }

    /**
     * Display galleries by category
     */
    public function byCategory($category)
    {
        $galleries = Gallery::active()
            ->byCategory($category)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Gallery::active()
            ->distinct('category')
            ->pluck('category')
            ->filter()
            ->values();

        return view('galleries.index', compact('galleries', 'categories', 'category'));
    }

    /**
     * Display the specified gallery
     */
    public function show(Gallery $gallery)
    {
        // Ensure gallery is active
        if (!$gallery->is_active) {
            abort(404);
        }

        $gallery->load('creator');
        
        // Get related galleries (same category)
        $related = Gallery::active()
            ->when($gallery->category, fn($q) => $q->byCategory($gallery->category))
            ->where('id', '!=', $gallery->id)
            ->limit(4)
            ->get();

        return view('galleries.show', compact('gallery', 'related'));
    }

    /**
     * Get galleries for dashboard (returns first 8 active galleries)
     */
    public function getDashboardGalleries()
    {
        return Gallery::active()
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();
    }
}
