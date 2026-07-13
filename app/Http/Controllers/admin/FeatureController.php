<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $features = Feature::orderBy('sort_order', 'asc');

            return DataTables::of($features)
                ->addIndexColumn()
                ->addColumn('icon_preview', function($row) {
                    if ($row->icon) {
                        // Menampilkan preview ikon dari class Font Awesome (atau sejenisnya)
                        return '<div class="text-center"><i class="' . e($row->icon) . ' fa-2x text-primary"></i></div>';
                    }
                    return '<span class="badge badge-secondary">No Icon</span>';
                })
                ->addColumn('title', function($row) {
                    // Gaya penulisan title dan description yang konsisten
                    $description = e($row->description) ?? '-';
                    return '<strong>' . e($row->title) . '</strong><br><small class="text-muted">' . $description . '</small>';
                })
                ->addColumn('status', function($row) {
                    // Gaya badge status yang konsisten
                    return $row->is_active
                        ? '<span class="badge badge-success">Active</span>'
                        : '<span class="badge badge-secondary">Inactive</span>';
                })
                ->addColumn('action', function($row) {
                    // Gaya tombol aksi yang konsisten
                    $editUrl = route('admin.features.edit', $row->id);
                    $deleteUrl = route('admin.features.destroy', $row->id);

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
                ->rawColumns(['icon_preview', 'title', 'status', 'action'])
                ->make(true);
        }

        return view('admin.features.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.features.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        // Logika checkbox 'is_active' yang konsisten
        $validated['is_active'] = $request->has('is_active');

        Feature::create($validated);

        return redirect()->route('admin.features.index')
            ->with('success', 'Feature created successfully!');
    }

    /**
     * Display the specified resource.
     */
    // public function show(Feature $feature)
    // {
    //     // Biasanya tidak digunakan di admin panel CRUD, tapi bisa ditambahkan jika perlu
    //     return redirect()->route('admin.features.edit', $feature);
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feature $feature)
    {
        return view('admin.features.edit', compact('feature'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feature $feature)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $feature->update($validated);

        return redirect()->route('admin.features.index')
            ->with('success', 'Feature updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feature $feature)
    {
        $feature->delete();

        // Format respons JSON yang konsisten untuk AJAX
        return response()->json([
            'success' => true,
            'message' => 'Feature deleted successfully!'
        ]);
    }

    /**
     * Get statistics for the features.
     */
    public function stats()
    {
        $totalFeatures = Feature::count();
        $activeFeatures = Feature::where('is_active', true)->count();
        // Statistik yang relevan untuk model Feature
        $withIcon = Feature::whereNotNull('icon')->where('icon', '!=', '')->count();

        return response()->json([
            'total_features' => $totalFeatures,
            'active_features' => $activeFeatures,
            'with_icon' => $withIcon,
        ]);
    }
}

