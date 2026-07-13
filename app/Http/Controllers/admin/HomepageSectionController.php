<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class HomepageSectionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sections = HomepageSection::orderBy('created_at', 'desc');

            return DataTables::of($sections)
                ->addIndexColumn()
                ->addColumn('banner', function($row) {
                    if ($row->banner_image) {
                        $url = Storage::url($row->banner_image);
                        return '<img src="'.$url.'" alt="Banner" class="img-thumbnail" style="max-width: 100px; max-height: 60px; object-fit: cover;">';
                    }
                    return '<span class="badge badge-secondary">No Image</span>';
                })
                ->addColumn('title', function($row) {
                    return '<strong>'.$row->title.'</strong>';
                })
                ->addColumn('description', function($row) {
                    return $row->description ?
                        '<small class="text-muted">'.Str::limit($row->description, 80).'</small>' :
                        '<span class="text-muted">-</span>';
                })
                ->addColumn('cta', function($row) {
                    if ($row->cta_text && $row->cta_link) {
                        return '<span class="badge badge-info">'.$row->cta_text.'</span><br>
                                <small class="text-muted">'.Str::limit($row->cta_link, 30).'</small>';
                    }
                    return '<span class="text-muted">No CTA</span>';
                })
                ->addColumn('action', function($row) {
                    $editUrl = route('admin.homepage.edit', $row->id);
                    $deleteUrl = route('admin.homepage.destroy', $row->id);

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
                ->rawColumns(['banner', 'title', 'description', 'cta', 'action'])
                ->make(true);
        }

        return view('admin.homepage.index');
    }

    public function create()
    {
        return view('admin.homepage.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'cta_text' => 'nullable|string|max:100',
            'cta_link' => 'nullable|url|max:255',
        ]);

        // Handle file upload
        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')
                ->store('homepage-banners', 'public');
        }

        HomepageSection::create($validated);

        return redirect()->route('admin.homepage.index')
            ->with('success', 'Homepage section created successfully!');
    }

    public function edit(HomepageSection $homepage)
    {
        return view('admin.homepage.edit', compact('homepage'));
    }

    public function update(Request $request, HomepageSection $homepage)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'cta_text' => 'nullable|string|max:100',
            'cta_link' => 'nullable|url|max:255',
        ]);

        // Handle file upload
        if ($request->hasFile('banner_image')) {
            // Delete old image if exists
            if ($homepage->banner_image) {
                Storage::disk('public')->delete($homepage->banner_image);
            }

            $validated['banner_image'] = $request->file('banner_image')
                ->store('homepage-banners', 'public');
        }

        $homepage->update($validated);

        return redirect()->route('admin.homepage.index')
            ->with('success', 'Homepage section updated successfully!');
    }

    public function destroy(HomepageSection $homepage)
    {
        // Delete image if exists
        if ($homepage->banner_image) {
            Storage::disk('public')->delete($homepage->banner_image);
        }

        $homepage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Homepage section deleted successfully!'
        ]);
    }

    public function stats(){
        $totalSections = HomepageSection::count();
        $withCta = HomepageSection::whereNotNull('cta_text')->whereNotNull('cta_link')->count();
        $withBanners = HomepageSection::whereNotNull('banner_image')->count();
        return response()->json([
            'total_sections' => $totalSections,
            'with_cta' => $withCta,
            'with_banners' => $withBanners
        ]);
    }
}
