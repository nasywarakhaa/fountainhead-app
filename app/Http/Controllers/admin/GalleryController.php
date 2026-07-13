<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galleries; // Menggunakan nama model yang Anda berikan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $galleries = Galleries::orderBy('sort_order', 'asc');

            return DataTables::of($galleries)
                ->addIndexColumn()
                ->addColumn('image_preview', function($row) {
                    if ($row->image) {
                        $url = Storage::url($row->image);
                        return '<img src="'.$url.'" alt="Gallery Image" class="img-thumbnail" style="width: 150px; height: 100px; object-fit: cover; border-radius: 8px;">';
                    }
                    return '<span class="badge badge-secondary">No Image</span>';
                })
                ->addColumn('details', function($row) {
                    $title = '<strong>'.e($row->title).'</strong>';
                    $description = $row->description ? '<br><small class="text-muted">'.e(substr($row->description, 0, 100)).'...</small>' : '';
                    return $title . $description;
                })
                ->addColumn('category', function($row) {
                    return $row->category ? '<span class="badge badge-info">'.e($row->category).'</span>' : '<span class="text-muted">-</span>';
                })
                ->addColumn('status', function($row) {
                    return $row->is_featured ?
                        '<span class="badge badge-success">Featured</span>' :
                        '<span class="badge badge-light">Regular</span>';
                })
                ->addColumn('action', function($row) {
                    $editUrl = route('admin.galleries.edit', $row->id);
                    $deleteUrl = route('admin.galleries.destroy', $row->id);
                    return '
                        <div class="btn-group" role="group">
                            <a href="'.$editUrl.'" class="btn btn-sm btn-info" title="Edit"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-sm btn-danger delete-btn" data-url="'.$deleteUrl.'" title="Delete"><i class="fas fa-trash"></i></button>
                        </div>
                    ';
                })
                ->rawColumns(['image_preview', 'details', 'category', 'status', 'action'])
                ->make(true);
        }

        return view('admin.galleries.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.galleries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('galleries', 'public');
        }

        $validated['is_featured'] = $request->has('is_featured');

        Galleries::create($validated);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Gallery image added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Galleries $gallery) // Route model binding
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Galleries $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }
            $validated['image'] = $request->file('image')->store('galleries', 'public');
        }

        $validated['is_featured'] = $request->has('is_featured');

        $gallery->update($validated);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Gallery image updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galleries $gallery)
    {
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gallery image deleted successfully!'
        ]);
    }

    /**
     * Get statistics for the dashboard cards.
     */
    public function stats()
    {
        $totalImages = Galleries::count();
        $featuredImages = Galleries::where('is_featured', true)->count();
        $uniqueCategories = Galleries::distinct()->count('category');

        return response()->json([
            'total_images' => $totalImages,
            'featured_images' => $featuredImages,
            'unique_categories' => $uniqueCategories,
        ]);
    }
}
