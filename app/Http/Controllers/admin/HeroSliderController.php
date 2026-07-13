<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class HeroSliderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sliders = HeroSlider::orderBy('sort_order', 'asc');

            return DataTables::of($sliders)
                ->addIndexColumn()
                ->addColumn('image_preview', function($row) {
                    if ($row->image) {
                        $url = Storage::url($row->image);
                        return '<img src="'.$url.'" alt="Slider" class="img-thumbnail" style="max-width: 150px; height: 80px; object-fit: cover;">';
                    }
                    return '<span class="badge badge-secondary">No Image</span>';
                })
                ->addColumn('title', function($row) {
                    return '<strong>'.$row->title.'</strong><br><small class="text-muted">'.($row->subtitle ?? '-').'</small>';
                })
                ->addColumn('cta', function($row) {
                    if ($row->cta_text && $row->cta_link) {
                        return '<span class="badge badge-info">'.$row->cta_text.'</span><br><small class="text-muted">'.$row->cta_link.'</small>';
                    }
                    return '<span class="text-muted">No CTA</span>';
                })
                ->addColumn('status', function($row) {
                    return $row->is_active ?
                        '<span class="badge badge-success">Active</span>' :
                        '<span class="badge badge-secondary">Inactive</span>';
                })
                ->addColumn('action', function($row) {
                    $editUrl = route('admin.hero-sliders.edit', $row->id);
                    $deleteUrl = route('admin.hero-sliders.destroy', $row->id);

                    return '
                        <div class="btn-group" role="group">
                            <a href="'.$editUrl.'" class="btn btn-sm btn-info" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger delete-btn"
                                    data-id="'.$row->id.'"
                                    data-url="'.$deleteUrl.'"
                                    title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['image_preview', 'title', 'cta', 'status', 'action'])
                ->make(true);
        }

        return view('admin.hero-sliders.index');
    }
    /**
     * Get user-friendly routes for CTA dropdown
     */
    private function getAvailableRoutes()
    {
        return [
            '' => '-- No Link / Custom URL --',
            route('home') => 'Home Page',
            route('coliving.index') => 'Coliving Rooms',
            route('cafe.index') => 'Cafe & Events',
            route('cafe.book-event') => 'Book Cafe Event',
            route('about') => 'About Us',
            route('contact') => 'Contact Us',
            'custom' => 'Custom URL (enter manually)',
        ];
    }
    public function create()
    {
        $routes = $this->getAvailableRoutes();
        return view('admin.hero-sliders.create', compact('routes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'cta_text' => 'nullable|string|max:100',
            'cta_link' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('hero-sliders', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        HeroSlider::create($validated);

        return redirect()->route('admin.hero-sliders.index')
            ->with('success', 'Hero slider created successfully!');
    }

    public function edit(HeroSlider $heroSlider)
    {
        $routes = $this->getAvailableRoutes();
        return view('admin.hero-sliders.edit', compact('heroSlider','routes'));
    }

    public function update(Request $request, HeroSlider $heroSlider)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'cta_text' => 'nullable|string|max:100',
            'cta_link' => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($heroSlider->image) {
                Storage::disk('public')->delete($heroSlider->image);
            }
            $validated['image'] = $request->file('image')->store('hero-sliders', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $heroSlider->update($validated);

        return redirect()->route('admin.hero-sliders.index')
            ->with('success', 'Hero slider updated successfully!');
    }

    public function destroy(HeroSlider $heroSlider)
    {
        if ($heroSlider->image) {
            Storage::disk('public')->delete($heroSlider->image);
        }

        $heroSlider->delete();

        return response()->json([
            'success' => true,
            'message' => 'Hero slider deleted successfully!'
        ]);
    }
    public function stats()
    {
        $totalSliders = HeroSlider::count();
        $activeSliders = HeroSlider::where('is_active', true)->count();
        $withCTA = HeroSlider::whereNotNull('cta_text')->whereNotNull('cta_link')->count();

        return response()->json([
            'total_sliders' => $totalSliders,
            'active_sliders' => $activeSliders,
            'with_cta' => $withCTA,
        ]);
    }
}
