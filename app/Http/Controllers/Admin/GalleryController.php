<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        $categories = Gallery::getCategories();

        return view('admin.galleries.index', compact('galleries', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Gallery::getCategories();
        return view('admin.galleries.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_alt' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($validated['title']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('galleries', $filename, 'public');
            $validated['image'] = $path;
        }

        $validated['created_by'] = auth()->id();
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        Gallery::create($validated);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        return view('admin.galleries.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        $categories = Gallery::getCategories();
        return view('admin.galleries.edit', compact('gallery', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_alt' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }

            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($validated['title']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('galleries', $filename, 'public');
            $validated['image'] = $path;
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? $gallery->order;

        $gallery->update($validated);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        // Delete image from storage
        if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil dihapus');
    }

    /**
     * Toggle gallery status
     */
    public function toggleStatus(Gallery $gallery)
    {
        $gallery->update(['is_active' => !$gallery->is_active]);

        return back()->with('success', 'Status galeri berhasil diubah');
    }

    /**
     * Reorder galleries
     */
    public function reorder(Request $request)
    {
        $order = $request->input('order', []);
        
        foreach ($order as $index => $id) {
            Gallery::find($id)?->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Filter by category
     */
    public function filterByCategory(Request $request)
    {
        $category = $request->input('category');
        
        if ($category) {
            $galleries = Gallery::byCategory($category)
                ->orderBy('order')
                ->orderBy('created_at', 'desc')
                ->paginate(12);
        } else {
            $galleries = Gallery::orderBy('order')
                ->orderBy('created_at', 'desc')
                ->paginate(12);
        }

        $categories = Gallery::getCategories();

        return view('admin.galleries.index', compact('galleries', 'categories', 'category'));
    }
}
