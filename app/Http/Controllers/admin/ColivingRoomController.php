<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ColivingRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ColivingRoomController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rooms = ColivingRoom::query();

            return DataTables::of($rooms)
                ->addIndexColumn()
                ->addColumn('thumbnail', function($row) {
                    if ($row->thumbnail) {
                        return '<img src="'.Storage::url($row->thumbnail).'" width="60" class="rounded">';
                    }
                    return '<span class="badge badge-secondary">No Image</span>';
                })
                ->addColumn('price', function($row) {
                    return 'Rp ' . number_format($row->price_per_night, 0, ',', '.');
                })
                ->addColumn('status', function($row) {
                    if ($row->is_available) {
                        return '<span class="badge badge-success">Available</span>';
                    }
                    return '<span class="badge badge-danger">Not Available</span>';
                })
                ->addColumn('featured', function($row) {
                    return $row->is_featured ?
                        '<i class="fas fa-star text-warning"></i>' :
                        '<i class="far fa-star text-muted"></i>';
                })
                ->addColumn('action', function($row) {
                    $editUrl = route('admin.coliving-rooms.edit', $row->id);
                    $deleteUrl = route('admin.coliving-rooms.destroy', $row->id);

                    return '
                        <div class="btn-group">
                            <a href="'.$editUrl.'" class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-url="'.$deleteUrl.'">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['thumbnail', 'status', 'featured', 'action'])
                ->make(true);
        }

        return view('admin.coliving-rooms.index');
    }

    public function create()
    {
        return view('admin.coliving-rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'room_type' => 'required|in:single,double,shared,suite,dormitory',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'weekly_price' => 'nullable|numeric|min:0',
            'monthly_price' => 'nullable|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'room_size' => 'nullable|numeric|min:0',
            'beds_count' => 'required|integer|min:1',
            'bed_type' => 'required|in:single,double,queen,king,bunk',
            'floor' => 'nullable|integer',
            'bathroom_type' => 'required|in:private,shared',
            'total_units' => 'nullable|integer|min:1',
            'cancellation_policy' => 'nullable|string',
            'house_rules' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'thumbnail' => 'nullable|image|max:2048',
            'images.*' => 'nullable|image|max:2048',
        ]);

        // Thumbnail
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('coliving-rooms', 'public');
        }

        // Multiple images
        if ($request->hasFile('images')) {
            $validated['images'] = collect($request->file('images'))
                ->map(fn($img) => $img->store('coliving-rooms', 'public'))
                ->toArray();
        }

        // Boolean fields
        $validated['has_window'] = $request->boolean('has_window');
        $validated['has_balcony'] = $request->boolean('has_balcony');
        $validated['is_available'] = $request->boolean('is_available');
        $validated['is_featured'] = $request->boolean('is_featured');

        // JSON fields
        $validated['facilities'] = $request->input('facilities', []);
        $validated['amenities'] = $request->input('amenities', []);

        ColivingRoom::create($validated);

        return redirect()->route('admin.coliving-rooms.index')
            ->with('success', 'Room created successfully!');
    }

    public function edit(ColivingRoom $colivingRoom)
    {
        return view('admin.coliving-rooms.edit', compact('colivingRoom'));
    }

    public function update(Request $request, ColivingRoom $colivingRoom)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'room_type' => 'required|in:single,double,shared,suite,dormitory',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'weekly_price' => 'nullable|numeric|min:0',
            'monthly_price' => 'nullable|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'room_size' => 'nullable|numeric|min:0',
            'beds_count' => 'required|integer|min:1',
            'bed_type' => 'required|in:single,double,queen,king,bunk',
            'floor' => 'nullable|integer',
            'bathroom_type' => 'required|in:private,shared',
            'total_units' => 'nullable|integer|min:1',
            'cancellation_policy' => 'nullable|string',
            'house_rules' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'thumbnail' => 'nullable|image|max:2048',
            'images.*' => 'nullable|image|max:2048',
            'delete_thumbnail' => 'nullable|boolean',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'string',
        ]);

        $thumbnailDeleted = false;

        // Delete thumbnail
        if ($request->boolean('delete_thumbnail')) {
            if ($colivingRoom->thumbnail) {
                Storage::disk('public')->delete($colivingRoom->thumbnail);
                $thumbnailDeleted = true;
            }

            $validated['thumbnail'] = null;
        }

        // Update thumbnail
        if ($request->hasFile('thumbnail')) {
            if ($colivingRoom->thumbnail && !$thumbnailDeleted) {
                Storage::disk('public')->delete($colivingRoom->thumbnail);
            }

            $validated['thumbnail'] = $request->file('thumbnail')->store('coliving-rooms', 'public');
        }

        // Current gallery images
        $currentImages = $colivingRoom->images ?? [];

        // Delete selected images
        if ($request->filled('delete_images')) {
            $deleteImages = $request->input('delete_images', []);

            // Biar user tidak bisa manipulasi path dan hapus file lain
            $deleteImages = array_values(array_intersect($deleteImages, $currentImages));

            foreach ($deleteImages as $image) {
                Storage::disk('public')->delete($image);
            }

            $currentImages = array_values(array_diff($currentImages, $deleteImages));

            $validated['images'] = $currentImages;
        }

        // Add new images
        if ($request->hasFile('images')) {
            $newImages = collect($request->file('images'))
                ->map(fn($img) => $img->store('coliving-rooms', 'public'))
                ->toArray();

            $validated['images'] = array_values(array_merge($currentImages, $newImages));
        }

        // Boolean fields
        $validated['has_window'] = $request->boolean('has_window');
        $validated['has_balcony'] = $request->boolean('has_balcony');
        $validated['is_available'] = $request->boolean('is_available');
        $validated['is_featured'] = $request->boolean('is_featured');

        // JSON fields
        $validated['facilities'] = $request->input('facilities', []);
        $validated['amenities'] = $request->input('amenities', []);

        // Remove form-only fields before update
        unset($validated['delete_thumbnail'], $validated['delete_images']);

        $colivingRoom->update($validated);

        return redirect()->route('admin.coliving-rooms.index')
            ->with('success', 'Room updated successfully!');
    }

    public function destroy(ColivingRoom $colivingRoom)
    {
        // Delete images
        if ($colivingRoom->thumbnail) {
            Storage::disk('public')->delete($colivingRoom->thumbnail);
        }

        if ($colivingRoom->images) {
            foreach ($colivingRoom->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $colivingRoom->delete();

        return response()->json(['success' => true, 'message' => 'Room deleted successfully!']);
    }

    public function stats()
    {
        $totalRooms = ColivingRoom::count();
        $availableRooms = ColivingRoom::where('is_available', true)->count();
        $featuredRooms = ColivingRoom::where('is_featured', true)->count();
        $unavailableRooms = ColivingRoom::where('is_available', false)->count();

        return response()->json([
            'total_rooms' => $totalRooms,
            'available_rooms' => $availableRooms,
            'featured_rooms' => $featuredRooms,
            'unavailable_rooms' => $unavailableRooms,
        ]);
    }
}
