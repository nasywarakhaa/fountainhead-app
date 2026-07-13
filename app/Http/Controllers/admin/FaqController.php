<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $faqs = Faq::orderBy('sort_order', 'asc');

            return DataTables::of($faqs)
                ->addIndexColumn()
                ->addColumn('question_details', function($row) {
                    $question = '<strong>'.e($row->question).'</strong>';
                    $answer = '<br><small class="text-muted">'.e(substr($row->answer, 0, 150)).'...</small>';
                    return $question . $answer;
                })
                ->addColumn('category', function($row) {
                    return $row->category ? '<span class="badge badge-info">'.e($row->category).'</span>' : '<span class="text-muted">-</span>';
                })
                ->addColumn('status', function($row) {
                    return $row->is_active ?
                        '<span class="badge badge-success">Active</span>' :
                        '<span class="badge badge-secondary">Inactive</span>';
                })
                ->addColumn('action', function($row) {
                    $editUrl = route('admin.faqs.edit', $row->id);
                    $deleteUrl = route('admin.faqs.destroy', $row->id);
                    return '
                        <div class="btn-group" role="group">
                            <a href="'.$editUrl.'" class="btn btn-sm btn-info" title="Edit"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-sm btn-danger delete-btn" data-url="'.$deleteUrl.'" title="Delete"><i class="fas fa-trash"></i></button>
                        </div>
                    ';
                })
                ->rawColumns(['question_details', 'category', 'status', 'action'])
                ->make(true);
        }

        return view('admin.faqs.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Faq::create($validated);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $faq->update($validated);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return response()->json([
            'success' => true,
            'message' => 'FAQ deleted successfully!'
        ]);
    }

    /**
     * Get statistics for the dashboard cards.
     */
    public function stats()
    {
        $totalFaqs = Faq::count();
        $activeFaqs = Faq::where('is_active', true)->count();
        $uniqueCategories = Faq::distinct()->count('category');

        return response()->json([
            'total_faqs' => $totalFaqs,
            'active_faqs' => $activeFaqs,
            'unique_categories' => $uniqueCategories,
        ]);
    }
}
