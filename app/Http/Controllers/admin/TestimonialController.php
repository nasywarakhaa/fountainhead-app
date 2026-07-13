<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $testimonials = Testimonial::orderBy('sort_order', 'asc');

            return DataTables::of($testimonials)
                ->addIndexColumn()
                ->addColumn('customer_preview', function($row) {
                    if ($row->customer_image) {
                        $url = Storage::url($row->customer_image);
                        return '<img src="' . $url . '" alt="' . e($row->customer_name) . '" class="img-thumbnail rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">';
                    }
                    // Fallback avatar dengan inisial nama
                    $initials = strtoupper(substr($row->customer_name, 0, 2));
                    return '<div class="avatar-circle" style="width: 60px; height: 60px; background-color: #6c757d; color: white; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: bold; font-size: 1.2rem;">' . $initials . '</div>';
                })
                ->addColumn('customer_info', function($row) {
                    $role = e($row->customer_role) ?? 'Customer';
                    return '<strong>' . e($row->customer_name) . '</strong><br><small class="text-muted">' . $role . '</small>';
                })
                ->addColumn('rating', function($row) {
                    $stars = '';
                    $rating = $row->rating ?? 0;
                    for ($i = 1; $i <= 5; $i++) {
                        $stars .= '<i class="fas fa-star ' . ($i <= $rating ? 'text-warning' : 'text-muted') . '"></i>';
                    }
                    return $stars;
                })
                ->addColumn('status', function($row) {
                    return $row->is_featured
                        ? '<span class="badge badge-primary">Featured</span>'
                        : '<span class="badge badge-secondary">Standard</span>';
                })
                ->addColumn('action', function($row) {
                    $editUrl = route('admin.testimonials.edit', $row->id);
                    $deleteUrl = route('admin.testimonials.destroy', ''.$row->id);


                    return '
                        <div class="btn-group" role="group">
                            <a href="' . $editUrl . '" class="btn btn-sm btn-info" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger delete-btn"
                                    data-id="' . $row->id . '"
                                    data-url="' . $deleteUrl . '"
                                    title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['customer_preview', 'customer_info', 'rating', 'status', 'action'])
                ->make(true);
        }

        return view('admin.testimonials.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_role' => 'nullable|string|max:255',
            'customer_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'testimonial_text' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('customer_image')) {
            $validated['customer_image'] = $request->file('customer_image')->store('testimonials', 'public');
        }

        $validated['is_featured'] = $request->has('is_featured');

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_role' => 'nullable|string|max:255',
            'customer_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'testimonial_text' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('customer_image')) {
            // Hapus gambar lama jika ada
            if ($testimonial->customer_image) {
                Storage::disk('public')->delete($testimonial->customer_image);
            }
            $validated['customer_image'] = $request->file('customer_image')->store('testimonials', 'public');
        }

        $validated['is_featured'] = $request->has('is_featured');

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        // Hapus gambar dari storage jika ada
        if ($testimonial->customer_image) {
            Storage::disk('public')->delete($testimonial->customer_image);
        }

        $testimonial->delete();

        return response()->json([
            'success' => true,
            'message' => 'Testimonial deleted successfully!'
        ]);
    }

    /**
     * Get statistics for the testimonials.
     */
    public function stats()
    {
        $totalTestimonials = Testimonial::count();
        $featuredTestimonials = Testimonial::featured()->count();
        $averageRating = Testimonial::avg('rating');

        return response()->json([
            'total_testimonials' => $totalTestimonials,
            'featured_testimonials' => $featuredTestimonials,
            'average_rating' => number_format($averageRating, 1),
        ]);
    }
}
