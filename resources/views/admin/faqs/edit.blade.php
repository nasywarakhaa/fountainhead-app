@extends('layouts.app')

@section('title', 'Edit FAQ')

@section('styles')
<style>
/* Style helper yang konsisten */
.bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.bg-gradient-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
.bg-gradient-warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
.form-control-lg { font-size: 1.1rem; padding: 0.75rem 1rem; }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-1"><i class="fas fa-edit mr-2 text-primary"></i>Edit FAQ</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.faqs.index') }}">FAQs</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('admin.faqs.update', $faq) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-lg-8">
                <!-- Kartu FAQ Details -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header bg-gradient-primary text-white" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>FAQ Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="question" class="font-weight-bold">Question <span class="text-danger">*</span></label>
                            <input type="text" name="question" id="question" class="form-control form-control-lg @error('question') is-invalid @enderror" value="{{ old('question', $faq->question) }}" required>
                            @error('question')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="answer" class="font-weight-bold">Answer <span class="text-danger">*</span></label>
                            <textarea name="answer" id="answer" rows="6" class="form-control @error('answer') is-invalid @enderror" required>{{ old('answer', $faq->answer) }}</textarea>
                            @error('answer')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                 <!-- Kartu Category -->
                 <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header bg-gradient-success text-white" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-tags mr-2"></i>Category</h5>
                    </div>
                    <div class="card-body p-4">
                         <div class="form-group">
                            <label for="category" class="font-weight-bold">Category</label>
                            <input type="text" name="category" id="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category', $faq->category) }}">
                            @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-lg-4">
                 <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header bg-gradient-warning text-white" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Info</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-1"><small class="text-muted">Created:</small> {{ $faq->created_at->format('d M Y H:i') }}</p>
                        <p class="mb-0"><small class="text-muted">Updated:</small> {{ $faq->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #3052ea 0%, #a2924b 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-cog mr-2"></i>Settings & Status</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="sort_order" class="font-weight-bold">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $faq->sort_order) }}">
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ $faq->is_active ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">Set as Active</label>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="fas fa-save mr-2"></i>Update FAQ</button>
                        <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary btn-lg btn-block"><i class="fas fa-times mr-2"></i>Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
